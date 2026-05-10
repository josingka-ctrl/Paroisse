<?php
// config/init.php
require_once __DIR__ . '/database.php';

try {
    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Sélectionner la base de données
    $pdo->exec("USE `" . DB_NAME . "`");

    // Créer la table admins
    $sqlAdmins = "CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($sqlAdmins);

    // Créer la table articles
    $sqlArticles = "CREATE TABLE IF NOT EXISTS `articles` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL UNIQUE,
        `content` TEXT NOT NULL,
        `image` VARCHAR(255) DEFAULT NULL,
        `author_id` INT DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`author_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($sqlArticles);

    // Créer l'administrateur par défaut s'il n'y en a aucun
    $stmt = $pdo->query("SELECT COUNT(*) FROM `admins`");
    if ($stmt->fetchColumn() == 0) {
        $defaultUser = 'admin';
        $defaultPass = password_hash('123456', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO `admins` (`username`, `password`) VALUES (?, ?)");
        $insertAdmin->execute([$defaultUser, $defaultPass]);
    }

} catch (PDOException $e) {
    die("Erreur lors de l'initialisation de la base de données : " . $e->getMessage());
}
