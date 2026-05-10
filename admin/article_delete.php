<?php
// admin/article_delete.php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_login();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {
        // Fetch image to delete it from uploads
        $stmt_img = $pdo->prepare("SELECT image FROM articles WHERE id = ?");
        $stmt_img->execute([$id]);
        $image = $stmt_img->fetchColumn();

        // Delete DB record
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->execute([$id]);

        // Delete file
        if ($image && file_exists(dirname(__DIR__) . '/uploads/' . $image)) {
            unlink(dirname(__DIR__) . '/uploads/' . $image);
        }

    } catch (PDOException $e) {
        die("Erreur de suppression.");
    }
}

header('Location: articles.php?msg=deleted');
exit;
