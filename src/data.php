<?php 

require __DIR__ . "/connectDB.php";


// ********** Récupération des données de la BDD **********

// Expérience de conduite
function getExpConduite() {
    global $pdo;
    $query = "SELECT ec.idExpConduite, ec.dateExpConduite, ec.heure_debut, ec.heure_fin, ec.km, m.nomMeteo, tt.typeTrafic, tr.typeRouteNom FROM experience_conduite ec JOIN meteo m USING (idMeteo) JOIN type_trafic tt USING (idTrafic) JOIN type_route tr USING (idTypeRoute);";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

// Types de manoeuvres
function getTypeManoeuvre() {
    global $pdo;
    $query = "SELECT * FROM type_manoeuvre";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

// Météo
function getMeteo() {
    global $pdo;
    $query = "SELECT * FROM meteo";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

// Type de route
function getTypeRoute() {
    global $pdo;
    $query = "SELECT * FROM type_route";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

// Type de trafic
function getTypeTrafic() {
    global $pdo;
    $query = "SELECT * FROM type_trafic";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

// Expériences manoeuvres
function getManoeuvres() {
    global $pdo;
    $query = "SELECT * FROM experience_manoeuvre";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

function getManoeuvresNoms():array {
    global $pdo;
    $query = "SELECT idManoeuvre, manoeuvreNom FROM type_manoeuvre";
    $manoeuvres = [];

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $manoeuvres[$row['idManoeuvre']] = $row['manoeuvreNom'];
        }
        return $manoeuvres;
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

function getManoeuvresParExp():array {
    global $pdo;
    $query = "SELECT idManoeuvre, idExpConduite FROM experience_manoeuvre";

    $result = [];

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // On regroupe en un tableau toutes les manoeuvres d'une expérience 
            $result[$row['idExpConduite']][] = $row['idManoeuvre'];
        }
        return $result;
    } catch (PDOException $e) {
        echo "Message d'erreur : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        var_dump($pdo->errorInfo());
        exit();
    }
}

function convertIdToStringManoeuvres() {
    // Récup des tableaux de manoeuvres en fonction des expConduite
    $manoeuvresParIdExpConduite = getManoeuvresParExp();
    
    // Récup des noms des manoeuvres
    $manoeuvresNoms = getManoeuvresNoms();
    
    $manoeuvresParExpConduite = [];
    
    foreach ($manoeuvresParIdExpConduite as $idExp => $idManoeuvres):
        foreach ($idManoeuvres as $id):
            $manoeuvresParExpConduite[$idExp][] = $manoeuvresNoms[$id] ?? 'Manoeuvre inconnue';
        endforeach;
    endforeach;
    
    return $manoeuvresParExpConduite;
}