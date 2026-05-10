<?php
// index.php
require_once __DIR__ . '/config/init.php'; // Initialise DB if needed
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Accueil';

// Fetch recent articles
try {
    $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
    $recent_articles = $stmt->fetchAll();
} catch (PDOException $e) {
    $recent_articles = [];
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Bienvenue à la Paroisse Saint Joseph</h1>
        <p>Une communauté vivante, guidée par la foi, l'espérance et la charité. Rejoignez-nous pour célébrer et partager l'amour du Christ.</p>
        <a href="<?= $base_url ?>/about.php" class="btn btn-primary">Découvrir notre paroisse</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Actualités & Articles</h2>
        
        <?php if (count($recent_articles) > 0): ?>
            <div class="articles-grid">
                <?php foreach ($recent_articles as $article): ?>
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
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?= $base_url ?>/articles.php" class="btn btn-primary">Voir toutes les actualités</a>
            </div>
        <?php else: ?>
            <p style="text-align: center;">Aucun article publié pour le moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="section" style="background-color: var(--white);">
    <div class="container">
        <h2 class="section-title">Nos Activités</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; text-align: center;">
            <div style="padding: 20px;">
                <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 15px;"><i class="fa-solid fa-church"></i></div>
                <h3 style="color: var(--primary-color); margin-bottom: 10px;">Messes</h3>
                <p style="color: var(--text-muted);">Rejoignez-nous pour les célébrations eucharistiques hebdomadaires.</p>
            </div>
            <div style="padding: 20px;">
                <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 15px;"><i class="fa-solid fa-book-bible"></i></div>
                <h3 style="color: var(--primary-color); margin-bottom: 10px;">Catéchèse</h3>
                <p style="color: var(--text-muted);">Formation spirituelle pour les enfants, jeunes et adultes.</p>
            </div>
            <div style="padding: 20px;">
                <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 15px;"><i class="fa-solid fa-handshake-angle"></i></div>
                <h3 style="color: var(--primary-color); margin-bottom: 10px;">Solidarité</h3>
                <p style="color: var(--text-muted);">Actions caritatives et entraide au sein de notre communauté.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
