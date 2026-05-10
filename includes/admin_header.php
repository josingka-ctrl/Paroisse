<?php
// includes/admin_header.php
require_once __DIR__ . '/functions.php';
require_login();
$base_url = get_base_url();
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? h($page_title) . ' - ' : '' ?>Administration Paroisse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/admin.css?v=2">
</head>
<body>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <a href="<?= $base_url ?>/" class="site-link">← Retour au site</a>
            <h2>Administration</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= $base_url ?>/admin/index.php" <?= ($current_page == 'index.php') ? 'class="active"' : '' ?>>Tableau de bord</a>
            <a href="<?= $base_url ?>/admin/articles.php" <?= ($current_page == 'articles.php' || strpos($current_page, 'article') === 0) ? 'class="active"' : '' ?>>Gérer les articles</a>
            <a href="<?= $base_url ?>/admin/logout.php" class="logout-link">Déconnexion</a>
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <h1><?= isset($page_title) ? h($page_title) : 'Tableau de bord' ?></h1>
            <div class="user-info">
                <span>Bienvenue, Admin</span>
            </div>
        </header>
        <div class="admin-content">
