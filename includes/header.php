<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = get_base_url();
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? h($page_title) . ' - ' : '' ?>Paroisse Saint Joseph</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css?v=3">
</head>
<body>

<header class="main-header">
    <div class="container">
        <div class="navbar">
            <a href="<?= $base_url ?>/" class="logo">
                <span class="logo-icon"><i class="fa-solid fa-cross"></i></span>
                <span class="logo-text">Paroisse Saint Joseph</span>
            </a>
            <nav class="nav-links">
                <a href="<?= $base_url ?>/" <?= ($current_page == 'index.php') ? 'class="active"' : '' ?>>Accueil</a>
                <a href="<?= $base_url ?>/articles.php" <?= ($current_page == 'articles.php' || strpos($current_page, 'article') === 0) ? 'class="active"' : '' ?>>Articles</a>
                <a href="<?= $base_url ?>/about.php" <?= ($current_page == 'about.php') ? 'class="active"' : '' ?>>À propos</a>
                <a href="<?= $base_url ?>/contact.php" <?= ($current_page == 'contact.php') ? 'class="active"' : '' ?>>Contact</a>
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="<?= $base_url ?>/admin/index.php" class="btn-admin-nav">Admin</a>
                <?php else: ?>
                    <a href="<?= $base_url ?>/admin/login.php" class="btn-admin-nav-discrete">Admin</a>
                <?php endif; ?>
            </nav>
            <button class="mobile-menu-btn" id="mobile-menu-btn">☰</button>
        </div>
    </div>
</header>
<main class="main-content">
