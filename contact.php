<?php
// contact.php
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Contact';
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error_msg = "Veuillez remplir tous les champs du formulaire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Veuillez fournir une adresse email valide.";
    } else {
        // Simulation d'envoi
        $success_msg = "Merci {$name}, votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.";
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding: 60px 20px; max-width: 600px;">
    <h1 class="section-title">Nous contacter</h1>
    
    <div style="background: var(--white); padding: 40px; border-radius: var(--border-radius); box-shadow: var(--shadow-sm);">
        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?= h($success_msg) ?></div>
        <?php endif; ?>
        
        <?php if ($error_msg): ?>
            <div class="alert alert-error"><?= h($error_msg) ?></div>
        <?php endif; ?>

        <form method="POST" action="contact.php">
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= isset($_POST['name']) ? h($_POST['name']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= isset($_POST['email']) ? h($_POST['email']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control" rows="6" required><?= isset($_POST['message']) ? h($_POST['message']) : '' ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Envoyer le message</button>
        </form>
        
        <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; text-align: center; color: var(--text-muted);">
            <p><strong>Paroisse Saint Joseph</strong></p>
            <p>goma , RDC</p>
            <p>Tél : +243 97 147 3252</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
