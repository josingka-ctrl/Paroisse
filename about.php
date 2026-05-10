<?php
// about.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'À propos';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding: 60px 20px;">
    <h1 class="section-title">À propos de notre paroisse</h1>
    
    <div style="background: var(--white); padding: 40px; border-radius: var(--border-radius); box-shadow: var(--shadow-sm); line-height: 1.8;">
        <p style="margin-bottom: 20px; font-size: 1.1rem;">
            Bienvenue à la Paroisse Saint Joseph. Nous sommes une communauté catholique engagée à vivre l'Évangile au cœur de notre ville. 
            Notre mission est d'accueillir, de célébrer, de servir et de grandir ensemble dans la foi.
        </p>

        <h3 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 15px;">Notre Histoire</h3>
        <p style="margin-bottom: 20px; color: var(--text-muted);">
            Fondée il y a plusieurs décennies, l'église Saint Joseph a toujours été un phare de lumière et d'espérance. 
            Au fil des années, notre communauté a grandi et s'est adaptée, mais notre engagement envers les enseignements du Christ est resté inébranlable.
        </p>

        <h3 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 15px;">Notre Équipe Pastorale</h3>
        <ul style="list-style-type: none; padding-left: 0; color: var(--text-muted);">
            <li style="margin-bottom: 10px;"><strong>Curé :</strong> Père Martin</li>
            <li style="margin-bottom: 10px;"><strong>Vicaire :</strong> Père Jean-Luc</li>
            <li style="margin-bottom: 10px;"><strong>Diacre :</strong> M. Paul Bernard</li>
            <li style="margin-bottom: 10px;"><strong>Secrétariat :</strong> Mme. Sylvie Laurent</li>
        </ul>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
