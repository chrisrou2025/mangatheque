<?php
// Assurez-vous que $mangas est défini et est un tableau
if (!isset($mangas) || !is_array($mangas)) {
    $mangas = []; // Initialise un tableau vide si $mangas n'est pas défini
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Ma Mangathèque</h1>

    <!-- Bouton pour ajouter un nouveau manga -->
    <div class="mb-6 text-center">
        <a href="/mangatheque/mangas/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            Ajouter un nouveau manga
        </a>
    </div>

    <?php if (empty($mangas)): ?>
        <!-- Message si aucun manga n'est trouvé -->
        <p class="text-center text-gray-600 text-lg">Aucun manga n'est disponible pour le moment.</p>
    <?php else: ?>
        <!-- Tableau pour afficher la liste des mangas -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Couverture
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Titre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Auteur
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Volume
                        </th>
                        <!-- NOUVELLE COLONNE TYPE AJOUTÉE ICI -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <!-- Colonne "Éditeur" existante -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Éditeur
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($mangas as $manga): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="w-16 h-24 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <?= htmlspecialchars($manga->getTitle()) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <?= htmlspecialchars($manga->getAuthor()) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <?= htmlspecialchars($manga->getVolume()) ?>
                            </td>
                            <!-- NOUVELLE CELLULE TYPE AJOUTÉE ICI -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <?= htmlspecialchars($manga->getType()) ?>
                                </span>
                            </td>
                            <!-- Cellule "Éditeur" existante -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <?= htmlspecialchars($manga->getPublisher()) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Lien pour voir la fiche détaillée -->
                                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Voir</a>
                                <!-- Lien pour éditer le manga -->
                                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/edit" class="text-yellow-600 hover:text-yellow-900 mr-4">Éditer</a>
                                <!-- Formulaire pour supprimer le manga -->
                                <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/delete" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce manga ?');">
                                    <button type="submit" class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>