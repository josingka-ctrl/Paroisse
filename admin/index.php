<?php
// admin/index.php
require_once dirname(__DIR__) . '/config/database.php';
$page_title = 'Tableau de bord';
require_once dirname(__DIR__) . '/includes/admin_header.php';

try {
    // Stats
    $stmt_total = $pdo->query("SELECT COUNT(*) FROM articles");
    $total_articles = $stmt_total->fetchColumn();

    $stmt_recent = $pdo->query("SELECT title, created_at FROM articles ORDER BY created_at DESC LIMIT 5");
    $recent_articles = $stmt_recent->fetchAll();

} catch (PDOException $e) {
    $total_articles = 0;
    $recent_articles = [];
}
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Articles</h3>
        <div class="value"><?= $total_articles ?></div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 style="font-size: 1.1rem; color: var(--primary-color);">Derniers articles ajoutés</h2>
        <a href="article_edit.php" class="btn btn-primary btn-sm">Nouvel article</a>
    </div>
    
    <div class="table-responsive">
        <?php if (count($recent_articles) > 0): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date de publication</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_articles as $art): ?>
                        <tr>
                            <td><?= h($art['title']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($art['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: var(--text-muted); padding: 15px;">Aucun article publié.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/admin_footer.php'; ?>
