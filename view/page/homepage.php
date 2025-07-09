<?php
// Assurez-vous que $mangas est défini et est un tableau
if (!isset($mangas) || !is_array($mangas)) {
    $mangas = []; // Initialise un tableau vide si $mangas n'est pas défini
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Découvrez Ma Mangathèque</h1>

    <?php if (empty($mangas)): ?>
        <div class="text-center py-10 bg-white rounded-lg shadow-md">
            <p class="text-xl text-gray-600 mb-4">Il n'y a pas encore de mangas dans votre collection.</p>
            <a href="/mangatheque/mangas/create" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out">
                Ajouter votre premier manga !
            </a>
        </div>
    <?php else: ?>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Vos Mangas Récents</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($mangas as $manga): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="block">
                        <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?= htmlspecialchars($manga->getTitle()) ?></h3>
                            <p class="text-sm text-gray-600">Vol. <?= htmlspecialchars($manga->getVolume()) ?></p>
                            <!-- Suppression de l'affichage de l'éditeur ici -->
                            <p class="text-xs text-gray-500 mt-1">Par <?= htmlspecialchars($manga->getAuthor()) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-10">
            <a href="/mangatheque/mangas" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out">
                Voir tous les mangas
            </a>
        </div>
    <?php endif; ?>
</div>
