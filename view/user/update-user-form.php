<?php
// Fichier : view/user/update-user-form.php
// $user est disponible ici grâce à l'inclusion dans le contrôleur

$title = "Modifier l'utilisateur : " . $user->getPseudo(); // Définition du titre de la page
ob_start(); // Démarre la mise en mémoire tampon de la sortie
?>

<div class="user-form">
    <h2>Modifier l'utilisateur : <?= $user->getPseudo() ?></h2>
    <form action="/mangatheque/user/update/<?= $user->getId() ?>" method="POST">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($user->getPseudo()) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>

        <label for="password">Nouveau mot de passe (laisser vide si inchangé):</label>
        <input type="password" id="password" name="password">

        <button type="submit">Mettre à jour</button>
    </form>
</div>

<?php
$content = ob_get_contents(); // Récupère le contenu mis en tampon
ob_end_clean(); // Arrête et nettoie la mise en mémoire tampon
require_once './view/base-html.php'; // Inclut le template de base
?>