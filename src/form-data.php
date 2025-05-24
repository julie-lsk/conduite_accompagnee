<?php

require __DIR__ . "/connectDB.php";

// ********** Récupération des données du formulaire **********
$date = $_POST['date'];
$heureDebut = $_POST['heureDebut'];
$heureFin = $_POST['heureFin'];
$km = $_POST['km'];
$meteoForm = $_POST['meteo'];
$typeRouteForm = $_POST['typeRoute'];
$traficForm = $_POST['trafic'];

// Si on a des manoeuvres, on les utilise, sinon c'est un tableau vide
$manoeuvresForm = $_POST['manoeuvre'] ?? [];


// Enregistrement d'une nouvelle expérience de conduite
function addNewExpConduite(PDO $pdo, array $data) {
    // prepare() pour éviter les injections de SQL
    $stmt = $pdo->prepare("INSERT INTO experience_conduite (dateExpConduite, heure_debut, heure_fin, km, idMeteo, idTrafic, idTypeRoute)
    VALUES (:date, :heureDebut, :heureFin, :km, :meteo, :trafic, :typeRoute)");

    $stmt->execute([
        ':date' => $data['date'],
        ':heureDebut' => $data['heureDebut'],
        ':heureFin' => $data['heureFin'],
        ':km' => $data['km'],
        ':meteo' => $data['meteo'],
        ':trafic' => $data['trafic'],
        ':typeRoute' => $data['typeRoute']
    ]);

    // Retourne l'id de l'expérience de conduite enregistrée
    return (int) $pdo->lastInsertId();
}

// Enregistrement des types de manoeuvre
function addNewsManoeuvres(PDO $pdo, int $idExpConduite, array $manoeuvres) {
    $stmt= $pdo->prepare("INSERT INTO experience_manoeuvre (idExpConduite, idManoeuvre) VALUES (:idExpConduite, :idManoeuvre)");

    // Sélection de plusieurs manoeuvres (un tableau)
    foreach($manoeuvres as $idManoeuvre) {
        $stmt->execute([
            ':idExpConduite' => $idExpConduite,
            ':idManoeuvre' => $idManoeuvre
        ]);
    }
}

// Exécution des requêtes + gestion des erreurs
try {
    $idExpConduite = addNewExpConduite($pdo, [
        'date' => $date,
        'heureDebut' => $heureDebut,
        'heureFin' => $heureFin,
        'km' => $km,
        'meteo' => $meteoForm,
        'trafic' => $traficForm,
        'typeRoute' => $typeRouteForm
    ]);

    // Garantit que les manoeuvres sont tjr un tableau
    if (!empty ($manoeuvresForm)) {
        $manoeuvres = is_array($manoeuvresForm) ? $manoeuvresForm : [$manoeuvresForm];
        addNewsManoeuvres($pdo, $idExpConduite, $manoeuvres);
    }

    // echo "La nouvelle expérience de conduite a bien été enregistrée !\n";

    // Redirection vers la page de récap
    header("Location: recapitulatif.php");
    exit;

} catch (PDOException $e) {
    echo "Il y a une erreur : " . $e->getMessage();
}