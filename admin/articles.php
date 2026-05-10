<?php
// admin/articles.php
require_once dirname(__DIR__) . '/config/database.php';
$page_title = 'Gestion des articles';
require_once dirname(__DIR__) . '/includes/admin_header.php';

try {
    $stmt = $pdo->query("SELECT id, title, created_at FROM articles ORDER BY created_at DESC");
    $articles = $stmt->fetchAll();
} catch (PDOException $e) {
    $articles = [];
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 style="font-size: 1.1rem; color: var(--primary-color);">Tous les articles</h2>
        <a href="article_edit.php" class="btn btn-primary btn-sm">Nouvel article</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">Article supprimé avec succès.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <?php if (count($articles) > 0): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date de publication</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $art): ?>
                        <tr>
                            <td><?= h($art['title']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($art['created_at'])) ?></td>
                            <td class="actions">
                                <a href="article_edit.php?id=<?= $art['id'] ?>" class="btn btn-primary btn-sm" style="background: var(--primary-light);">Modifier</a>
                                <a href="article_delete.php?id=<?= $art['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: var(--text-muted); padding: 15px;">Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/admin_footer.php'; ?>
