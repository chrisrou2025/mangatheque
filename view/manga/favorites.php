<?php
// Vue: ./view/manga/favorites.php
?>

<div class="container mx-auto p-4">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">⭐ Mes Mangas Favoris</h1>
    </div>

    <?php if (empty($favoriteMangas)): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg text-center">
            <div class="flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <p class="font-semibold">Vous n'avez pas encore ajouté de mangas à vos favoris.</p>
            </div>
            <p class="mt-2 text-sm">Parcourez la <a href="/mangatheque/mangas" class="text-blue-800 hover:underline font-medium">liste des mangas</a> pour trouver vos préférés !</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($favoriteMangas as $manga): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="block">
                        <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 truncate"><?= htmlspecialchars($manga->getTitle()) ?></h3>
                            <p class="text-sm text-gray-600">Vol. <?= htmlspecialchars($manga->getVolume()) ?></p>
                            <p class="text-xs text-gray-500 mt-1">Par <?= htmlspecialchars($manga->getAuthor()) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>