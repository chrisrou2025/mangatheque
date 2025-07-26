<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Ma Mangathèque' ?></title>
    <link rel="stylesheet" href="/mangatheque/public/css/styles.css">
    <link rel="icon" href="/mangatheque/public/favicon.ico" type="image/x-icon">
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
                <?php endif;
                ?>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <?= $content ?? '<p class="no-content">Pas de contenu à afficher.</p>' ?>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Ma Mangathèque. Tous droits réservés.</p>
    </footer>

    <script>
        /**
         * Fonction pour afficher une notification toast
         */
        function showToast(message, type = 'success') {
            // Définit les icônes selon le type
            const icons = {
                success: '✓',
                error: '✗',
                info: 'i'
            };

            // Crée l'élément toast
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <div class="toast-icon">
                        <span>${icons[type]}</span>
                    </div>
                    <div class="toast-message">
                        <p>${message}</p>
                    </div>
                    <div class="toast-close">
                        <button onclick="hideToast(this.parentElement.parentElement.parentElement)" class="close-btn">&times;</button>
                    </div>
                </div>
                <div class="progress-bar progress-bar-${type}"></div>
            `;

            // Ajoute le toast au container
            document.getElementById('toast-container').appendChild(toast);

            // Affiche le toast avec animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Masque automatiquement le toast après 4 secondes
            setTimeout(() => {
                hideToast(toast);
            }, 4000);
        }

        /**
         * Fonction pour masquer un toast
         */
        function hideToast(toast) {
            toast.classList.add('hide');
            toast.classList.remove('show');

            // Supprime l'élément du DOM après l'animation
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }

        /**
         * Fonction pour confirmer la déconnexion avec une alerte
         * Si l'utilisateur confirme, il est redirigé vers la page de déconnexion
         */
        function confirmLogout() {
            // Affiche une boîte de dialogue de confirmation
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                // Si l'utilisateur confirme, redirection vers la route de déconnexion
                window.location.href = '/mangatheque/logout';
            }
            // Si l'utilisateur annule, rien ne se passe (il reste sur la page actuelle)
        }

        // Vérifie s'il y a un message de succès en session et l'affiche
        <?php if (isset($_SESSION['success'])) : ?>
            // Affiche le message de succès en popup dès le chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                showToast('<?php echo addslashes($_SESSION['success']); ?>', 'success');
            });
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </script>
</body>

</html>