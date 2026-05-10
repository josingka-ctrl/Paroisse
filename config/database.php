<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'paroisse_st_joseph');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Sélectionner la base de données si elle existe
    $pdo->exec("USE `" . DB_NAME . "`");
} catch (PDOException $e) {
    if ($e->getCode() != 1049) { // 1049 = Unknown database
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
