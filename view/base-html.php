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

        /* Styles pour les coins arrondis sur tous les éléments */
        * {
            border-radius: 0.5rem;
            /* Applique un rayon de bordure par défaut */
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Messages d'erreur et de succès -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 mt-4">
            <strong class="font-bold">Erreur : </strong>
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mx-4 mt-4">
            <strong class="font-bold">Succès : </strong>
            <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <header class="bg-gray-800 text-white p-4 shadow-md">
        <nav class="container mx-auto flex justify-between items-center">
            <!-- Logo toujours présent -->
            <a href="/mangatheque" class="text-2xl font-bold text-orange-400 hover:text-orange-300 transition duration-300 ease-in-out">Ma Mangathèque</a>
            
            <div>
                <?php if (isset($_SESSION['id'])): ?>
                    <!-- Menu pour utilisateur connecté -->
                    <a href="/mangatheque/mangas" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out">Mangas</a>
                    <a href="/mangatheque/mangas/create" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium ml-4 transition duration-300 ease-in-out">Ajouter un manga</a>
                    
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

    <!-- Script JavaScript pour la confirmation de déconnexion -->
    <script>
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
    </script>
</body>

</html>