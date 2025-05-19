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