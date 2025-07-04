<?php
session_start(); // Ajoutez ceci au tout début de votre fichier homepage.php si ce n'est pas déjà fait

$title = "Page d'accueil";
ob_start();

// Affichage des messages de succès
if (isset($_SESSION['message_success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message_success'] . '</div>';
    unset($_SESSION['message_success']); // Supprimer le message après l'affichage
}

// Affichage des messages d'erreur
if (isset($_SESSION['message_error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['message_error'] . '</div>';
    unset($_SESSION['message_error']); // Supprimer le message après l'affichage
}

foreach ($users as $user) :
?>
<div class="user">
    <h2><?= $user->getPseudo() ?></h2>
    <p>Email: <?= $user->getEmail() ?></p>
    <p><a href="user/<?= $user->getId() ?>">Voir le user</a></p>
    <p><a href="user/delete/<?= $user->getId() ?>">Supprimer le user</a></p>
    <p><a href="user/update/<?= $user->getId() ?>">Modifier</a></p>
</div>
<?php
endforeach;
$content = ob_get_contents();
ob_end_clean();
require_once './view/base-html.php';