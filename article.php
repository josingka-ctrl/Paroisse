<?php
// article.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header('Location: articles.php');
    exit;
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("
        SELECT a.*, adm.username as author_name 
        FROM articles a 
        LEFT JOIN admins adm ON a.author_id = adm.id 
        WHERE a.slug = ?
    ");
    $stmt->execute([$slug]);
    $article = $stmt->fetch();

    if (!$article) {
        header('Location: articles.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$page_title = $article['title'];
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div class="article-detail-container">
        <?php if (!empty($article['image']) && file_exists(__DIR__ . '/uploads/' . $article['image'])): ?>
            <img src="<?= $base_url ?>/uploads/<?= h($article['image']) ?>" alt="<?= h($article['title']) ?>" class="article-detail-img">
        <?php endif; ?>

        <div class="article-detail-header">
            <h1><?= h($article['title']) ?></h1>
            <div class="article-detail-meta">
                Publié le <?= date('d/m/Y à H:i', strtotime($article['created_at'])) ?>
                <?php if ($article['author_name']): ?>
                    | Par <?= h($article['author_name']) ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="article-detail-body">
            <!-- Allow basic HTML like paragraphs and bold, usually you'd use a WYSIWYG editor but for this simple setup we nl2br it if it's plain text, or just output if it's considered safe html. Since requirements mention "simple architecture", we will assume newlines mean paragraphs. -->
            <?= nl2br(h($article['content'])) ?>
        </div>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
            <a href="<?= $base_url ?>/articles.php" class="btn" style="background: #e2e8f0; color: var(--text-main);">← Retour aux articles</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
