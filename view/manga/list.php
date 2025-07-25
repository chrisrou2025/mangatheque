<?php
// Assurez-vous que $mangas est défini et est un tableau
if (!isset($mangas) || !is_array($mangas)) {
    $mangas = []; // Initialise un tableau vide si $mangas n'est pas défini
}
?>

<?php if (empty($mangas)): ?>
    <p class="text-center text-gray-600 text-lg">Aucun manga n'est disponible pour le moment.</p>
<?php else: ?>
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

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Note
                    </th>
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
                            <img src="/mangatheque/public/covers/<?= $manga->getCoverImage() ?>" alt="Couverture de <?= $manga->getTitle() ?>" class="w-16 h-24 object-cover rounded-md shadow-sm">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <?= $manga->getTitle() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <?= $manga->getAuthor() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <?= $manga->getVolume() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                <?= $manga->getType() ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <?php if ($manga->getAverageRating() !== null): ?>
                                <span class="font-semibold text-blue-600"><?= number_format($manga->getAverageRating(), 1) ?> / 5</span>
                                <div class="flex items-center mt-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <svg class="w-4 h-4 <?= $i <= round($manga->getAverageRating()) ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            <?= $manga->getPublisher() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="/mangatheque/mangas/<?= $manga->getId() ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Voir</a>
                            <a href="/mangatheque/mangas/<?= $manga->getId() ?>/edit" class="text-yellow-600 hover:text-yellow-900 mr-4">Éditer</a>
                            <form action="/mangatheque/mangas/<?= $manga->getId() ?>/delete" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce manga ?');">
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