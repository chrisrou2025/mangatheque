<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Ma Mangathèque' ?></title>
    <link rel="stylesheet" href="/mangatheque/public/css/styles.css">
</head>

<body>
    <div id="toast-container"></div>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message">
            <strong>Erreur : </strong>
            <span><?php echo $_SESSION['error']; ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <header class="header">
        <nav class="nav-container">
            <a href="/mangatheque" class="logo">Ma Mangathèque</a>

            <div class="nav-links">
                <a href="/mangatheque/mangas/top" class="nav-link">Top Favoris</a>

                <?php if (isset($_SESSION['id'])): ?>
                    <a href="/mangatheque/mangas" class="nav-link">Liste des Mangas</a>
                    <a href="/mangatheque/mangas/create" class="nav-link">Ajouter un nouveau Manga</a>
                    <a href="/mangatheque/mangas/favorites" class="btn-favorites">Mes Favoris</a>

                    <button onclick="confirmLogout()" class="btn-logout">
                        Déconnexion
                    </button>
                <?php else: ?>
                    <a href="/mangatheque/login" class="nav-link">Connexion</a>
                    <a href="/mangatheque/register" class="btn-register">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <?= $content ?? '<p class="no-content">Pas de contenu à afficher.</p>' ?>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Ma Mangathèque. Tous droits réservés.</p>
    </footer>

    <script src="/mangatheque/public/js/main.js"></script>

    <?php if (isset($_SESSION['success'])) : ?>
        <script>
            // Affiche le message de succès dès le chargement de la page
            displaySessionMessage('<?php echo addslashes($_SESSION['success']); ?>', 'success');
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</body>

</html>