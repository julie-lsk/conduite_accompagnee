<?php

require __DIR__ . "/connectDB.php";

global $pdo;

// ********** Récupération des données du formulaire **********

$date = $_POST['date'];
$heureDebut = $_POST['heureDebut'];
$heureFin = $_POST['heureFin'];
$km = $_POST['km'];
$meteoForm = $_POST['meteo'];
$typeRouteForm = $_POST['typeRoute'];
$traficForm = $_POST['trafic'];
$manoeuvresForm = $_POST['manoeuvre'];

var_dump($manoeuvresForm);

// Enregistrement d'une nouvelle expérience de conduite
try {
    // prepare() pour éviter les injections de SQL
    $stmt = $pdo->prepare("INSERT INTO experience_conduite (dateExpConduite, heure_debut, heure_fin, km, idMeteo, idTrafic, idTypeRoute)
    VALUES (:date, :heureDebut, :heureFin, :km, :meteo, :trafic, :typeRoute)");

    $stmt->execute([
        ':date' => $date,
        ':heureDebut' => $heureDebut,
        ':heureFin' => $heureFin,
        ':km' => $km,
        ':meteo' => $meteoForm,
        ':trafic' => $traficForm,
        ':typeRoute' => $typeRouteForm 
    ]);

    echo "La nouvelle expérience de conduite a bien été enregistrée !\n";
    var_dump($stmt);

    // Enregistrement des types de manoeuvre
    $idExpConduite = $pdo->lastInsertId();

    $stmtManoeuvre = $pdo->prepare("INSERT INTO experience_manoeuvre (idExpConduite, idManoeuvre) VALUES (:idExpConduite, :idManoeuvre)");

    // Insertion de plusieurs manoeuvres (un tableau)
    if (is_array($manoeuvresForm)) {
        foreach($manoeuvresForm as $idManoeuvre) {
            $stmtManoeuvre->execute([
                ':idExpConduite' => $idExpConduite,
                ':idManoeuvre' => $idManoeuvre
            ]);
        }
    } else {
        // Insertion d'une seule manoeuvre
        $stmtManoeuvre->execute([
            ':idExpConduite' => $idExpConduite,
            ':idManoeuvre' => $manoeuvresForm
        ]);
    }
} catch (PDOException $e) {
    echo "Il y a une erreur : " . $e->getMessage();
}