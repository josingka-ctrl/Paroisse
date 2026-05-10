<?php
// articles.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Articles & Actualités';

// Pagination and Search
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;
$offset = ($page - 1) * $per_page;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

try {
    if (!empty($search)) {
        // Query with search
        $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE title LIKE :search OR content LIKE :search");
        $search_param = "%{$search}%";
        $stmt_count->execute(['search' => $search_param]);
        $total_articles = $stmt_count->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search', $search_param, PDO::PARAM_STR);
    } else {
        // Normal query
        $stmt_count = $pdo->query("SELECT COUNT(*) FROM articles");
        $total_articles = $stmt_count->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM articles ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    }

    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $articles = $stmt->fetchAll();
} catch (PDOException $e) {
    $articles = [];
    $total_articles = 0;
}

$total_pages = ceil($total_articles / $per_page);

require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding: 60px 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
        <h1 class="section-title" style="margin-bottom: 0;">Actualités de la Paroisse</h1>
        
        <form method="GET" action="articles.php" style="display: flex; gap: 10px;">
            <input type="text" name="q" class="form-control" placeholder="Rechercher..." value="<?= h($search) ?>" style="width: 250px;">
            <button type="submit" class="btn btn-primary" title="Rechercher"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <?php if (!empty($search)): ?>
        <p style="margin-bottom: 20px; color: var(--text-muted);">Résultats pour : <strong><?= h($search) ?></strong></p>
    <?php endif; ?>

    <?php if (count($articles) > 0): ?>
        <div class="articles-grid">
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <?php if (!empty($article['image']) && file_exists(__DIR__ . '/uploads/' . $article['image'])): ?>
                        <img src="<?= $base_url ?>/uploads/<?= h($article['image']) ?>" alt="<?= h($article['title']) ?>" class="article-img">
                    <?php else: ?>
                        <div class="article-img" style="background-color: var(--primary-light); display: flex; align-items: center; justify-content: center; color: white;">Image non disponible</div>
                    <?php endif; ?>
                    <div class="article-content">
                        <div class="article-meta">Publié le <?= date('d/m/Y', strtotime($article['created_at'])) ?></div>
                        <h3 class="article-title"><?= h($article['title']) ?></h3>
                        <p class="article-excerpt">
                            <?= h(mb_substr(strip_tags($article['content']), 0, 100)) ?>...
                        </p>
                        <a href="<?= $base_url ?>/article.php?slug=<?= h($article['slug']) ?>" class="read-more">Lire la suite →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div style="display: flex; justify-content: center; margin-top: 40px; gap: 10px;">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?><?= !empty($search) ? '&q=' . urlencode($search) : '' ?>" 
                       class="btn <?= $i === $page ? 'btn-primary' : '' ?>"
                       style="<?= $i !== $page ? 'background: var(--white); color: var(--text-main); border: 1px solid #ddd;' : '' ?>">
                       <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div style="background: var(--white); padding: 40px; border-radius: var(--border-radius); text-align: center; color: var(--text-muted);">
            <p>Aucun article trouvé.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
