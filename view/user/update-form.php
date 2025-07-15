<?php
$title = "Editer utilisateur :  . $user->getPseudo()";
ob_start();
?>
<div class="user">
    <h1>Utilisateur <?= $user->getPseudo() ?></h1>
    <form action="/mangatheque/user/update/<?= $user->getId() ?>" method="POST">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" value="<?= $user->getPseudo() ?>">
    </div>
        <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?= $user->getEmail() ?>">
    </div>
        <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" value="<?= $user->getPassword() ?>">
    </div>
    <div>
        <input type="submit" value="modifier">
    </div>
    </form>
</div>
<?php

$content = ob_get_contents();
ob_end_clean();
require_once './view/base-html.php';