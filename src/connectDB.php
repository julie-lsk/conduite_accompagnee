<?php

$config = require __DIR__ . '/.env.php';

$host = $config['DB_HOST'];
$bddname = $config['DB_NAME'];
$user = $config['DB_USER'];
$password = $config['DB_PASSWORD'];

// Gestion des erreurs de connexion
try {
    $pdo = new PDO("mysql:host=$host;dbname=$bddname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur lors de la connexion à la BDD ! \n Erreur : " .  $e->getMessage();
}