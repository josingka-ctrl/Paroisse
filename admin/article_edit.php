<?php
// admin/article_edit.php
require_once dirname(__DIR__) . '/config/database.php';
$page_title = 'Éditer un article';
require_once dirname(__DIR__) . '/includes/admin_header.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id > 0;

$article = [
    'title' => '',
    'content' => '',
    'image' => ''
];

$error = '';
$success = '';

if ($is_edit) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    $fetched = $stmt->fetch();
    if ($fetched) {
        $article = $fetched;
    } else {
        $error = "Article introuvable.";
        $is_edit = false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $slug = slugify($title);
    $author_id = $_SESSION['admin_id'];
    
    // Check slug uniqueness
    $slug_check_query = "SELECT id FROM articles WHERE slug = ? " . ($is_edit ? "AND id != ?" : "");
    $slug_params = $is_edit ? [$slug, $id] : [$slug];
    $stmt_slug = $pdo->prepare($slug_check_query);
    $stmt_slug->execute($slug_params);
    if ($stmt_slug->fetchColumn()) {
        $slug = $slug . '-' . time(); // Append timestamp to make unique
    }

    if (empty($title) || empty($content)) {
        $error = "Le titre et le contenu sont obligatoires.";
    } else {
        // Image Upload
        $image = $article['image']; // Keep old image by default
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_filename = uniqid('img_') . '.' . $ext;
                $upload_dir = dirname(__DIR__) . '/uploads/';
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                    // Delete old image if exists
                    if ($is_edit && $image && file_exists($upload_dir . $image)) {
                        unlink($upload_dir . $image);
                    }
                    $image = $new_filename;
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $error = "Format d'image non autorisé.";
            }
        }

        if (!$error) {
            if ($is_edit) {
                $stmt = $pdo->prepare("UPDATE articles SET title = ?, slug = ?, content = ?, image = ? WHERE id = ?");
                if ($stmt->execute([$title, $slug, $content, $image, $id])) {
                    $success = "Article mis à jour avec succès.";
                    $article['title'] = $title;
                    $article['content'] = $content;
                    $article['image'] = $image;
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO articles (title, slug, content, image, author_id) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$title, $slug, $content, $image, $author_id])) {
                    $success = "Article créé avec succès.";
                    $id = $pdo->lastInsertId();
                    $is_edit = true;
                    $article['title'] = $title;
                    $article['content'] = $content;
                    $article['image'] = $image;
                }
            }
        }
    }
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 style="font-size: 1.1rem; color: var(--primary-color);">
            <?= $is_edit ? 'Modifier l\'article' : 'Créer un nouvel article' ?>
        </h2>
        <a href="articles.php" class="btn btn-sm" style="background: #e2e8f0; color: var(--text-main);">← Retour</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= h($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= h($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= h($article['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Image d'illustration (optionnelle)</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <?php 
                $img_src = '';
                if ($article['image'] && file_exists(dirname(__DIR__) . '/uploads/' . $article['image'])) {
                    $img_src = '../uploads/' . $article['image'];
                }
            ?>
            <img id="image-preview" class="img-preview" src="<?= h($img_src) ?>" alt="Aperçu">
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea id="content" name="content" class="form-control" required><?= h($article['content']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Mettre à jour' : 'Publier' ?></button>
    </form>
</div>

<?php require_once dirname(__DIR__) . '/includes/admin_footer.php'; ?>
