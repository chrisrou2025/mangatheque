<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Ma Mangathèque' ?></title>
    <!-- Inclure Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styles personnalisés pour la police Inter */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Container pour les notifications toast -->
    <div id="toast-container"></div>

    <!-- Messages d'erreur (restent en bannière) -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 mt-4">
            <strong class="font-bold">Erreur : </strong>
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <header class="bg-gray-800 text-white p-4 shadow-md">
        <nav class="container mx-auto flex justify-between items-center">
            <!-- Logo toujours présent -->
            <a href="/mangatheque" class="text-2xl font-bold text-orange-400 hover:text-orange-300 transition duration-300 ease-in-out">Ma Mangathèque</a>

            <div>
                <?php if (isset($_SESSION['id'])): ?>
                    <!-- Bouton de déconnexion avec alerte JavaScript -->
                    <button onclick="confirmLogout()" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium ml-4 transition duration-300 ease-in-out">
                        Déconnexion
                    </button>
                <?php else: ?>
                    <!-- Menu pour utilisateur non connecté -->
                    <a href="/mangatheque/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out">Connexion</a>
                    <a href="/mangatheque/register" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium ml-2 transition duration-300 ease-in-out">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="flex-grow py-8">
        <?= $content ?? '<p class="text-center text-gray-600 text-xl">Pas de contenu à afficher.</p>' ?>
    </main>

    <footer class="bg-gray-800 text-white p-4 text-center text-sm mt-auto">
        <p>&copy; <?= date('Y') ?> Ma Mangathèque. Tous droits réservés.</p>
    </footer>

    <!-- Scripts JavaScript -->
    <script>
        /**
         * Fonction pour afficher une notification toast
         */
        function showToast(message, type = 'success') {
            // Définit les couleurs selon le type
            const colors = {
                success: 'bg-green-500 text-white',
                error: 'bg-red-500 text-white',
                info: 'bg-blue-500 text-white'
            };

            // Définit les icônes selon le type
            const icons = {
                success: '✓',
                error: '✗',
                info: 'i'
            };

            // Crée l'élément toast
            const toast = document.createElement('div');
            toast.className = `toast ${colors[type]} p-4 rounded-lg shadow-lg`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-3">
                        <span class="text-xl font-bold">${icons[type]}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <div class="flex-shrink-0 ml-3">
                        <button onclick="hideToast(this.parentElement.parentElement)" class="text-white hover:text-gray-200 font-bold text-xl">&times;</button>
                    </div>
                </div>
                <div class="progress-bar ${type === 'success' ? 'bg-green-300' : type === 'error' ? 'bg-red-300' : 'bg-blue-300'}"></div>
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