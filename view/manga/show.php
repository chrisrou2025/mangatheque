<?php
// Assure que $manga est défini
if (!isset($manga)) {
    // Redirige ou affiche une erreur si le manga n'est pas passé
    header('Location: /mangatheque/mangas');
    exit();
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Fiche détaillée du Manga</h1>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg flex flex-col md:flex-row items-center md:items-start">
        <div class="md:mr-8 mb-6 md:mb-0">
            <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="w-48 h-72 object-cover rounded-lg shadow-md">
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars($manga->getTitle()) ?></h2>
            
            <!-- Remplacer l'ID par le type de manga -->
            <div class="mb-3">
                <strong class="text-gray-700">Type:</strong> 
                <span class="text-gray-900 bg-blue-100 px-2 py-1 rounded-full text-sm font-medium">
                    <?= htmlspecialchars($manga->getType()) ?>
                </span>
            </div>
            
            <div class="mb-3">
                <strong class="text-gray-700">Auteur:</strong> <span class="text-gray-900"><?= htmlspecialchars($manga->getAuthor()) ?></span>
            </div>
            <div class="mb-3">
                <strong class="text-gray-700">Volume:</strong> <span class="text-gray-900"><?= htmlspecialchars($manga->getVolume()) ?></span>
            </div>
            <!-- Affichage de la maison d'édition -->
            <div class="mb-3">
                <strong class="text-gray-700">Maison d'édition:</strong> <span class="text-gray-900"><?= htmlspecialchars($manga->getPublisher()) ?></span>
            </div>
            <div class="mb-6">
                <strong class="text-gray-700">Description:</strong>
                <p class="text-gray-900 mt-2 leading-relaxed"><?= nl2br(htmlspecialchars($manga->getDescription())) ?></p>
            </div>

            <div class="flex justify-between items-center mt-6">
                <!-- Bouton pour éditer le manga -->
                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/edit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Modifier
                </a>
                <!-- Bouton pour retourner à la liste -->
                <a href="/mangatheque/mangas" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>