<?php
// Assurez-vous que $mangas est défini et est un tableau
if (!isset($mangas) || !is_array($mangas)) {
    $mangas = []; // Initialise un tableau vide si $mangas n'est pas défini
}
?>

<div class="manga-list-container">
    <?php if (empty($mangas)): ?>
        <p class="no-manga-message">Aucun manga n'est disponible pour le moment.</p>
    <?php else: ?>
        <div class="table-container">
            <table class="manga-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="table-header-cell">
                            Couverture
                        </th>
                        <th scope="col" class="table-header-cell">
                            Titre
                        </th>
                        <th scope="col" class="table-header-cell">
                            Auteur
                        </th>
                        <th scope="col" class="table-header-cell">
                            Volume
                        </th>
                        <th scope="col" class="table-header-cell hide-on-mobile">
                            Type
                        </th>
                        <th scope="col" class="table-header-cell">
                            Note
                        </th>
                        <th scope="col" class="table-header-cell hide-on-mobile">
                            Éditeur
                        </th>
                        <th scope="col" class="table-header-cell">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach ($mangas as $manga): ?>
                        <tr>
                            <td class="table-cell">
                                <img src="/mangatheque/public/covers/<?= $manga->getCoverImage() ?>" 
                                     alt="Couverture de <?= $manga->getTitle() ?>" 
                                     class="manga-cover-table">
                            </td>
                            <td class="table-cell">
                                <?= $manga->getTitle() ?>
                            </td>
                            <td class="table-cell">
                                <?= $manga->getAuthor() ?>
                            </td>
                            <td class="table-cell">
                                <?= $manga->getVolume() ?>
                            </td>
                            <td class="table-cell hide-on-mobile">
                                <span class="type-badge">
                                    <?= $manga->getType() ?>
                                </span>
                            </td>
                            <td class="table-cell">
                                <?php if ($manga->getAverageRating() !== null): ?>
                                    <div class="rating-section">
                                        <span class="rating-number"><?= number_format($manga->getAverageRating(), 1) ?> / 5</span>
                                        <div class="stars-container">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <svg class="star <?= $i <= round($manga->getAverageRating()) ? 'star-gold' : 'star-gray' ?>" 
                                                     viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="rating-na">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-cell hide-on-mobile">
                                <?= $manga->getPublisher() ?>
                            </td>
                            <td class="table-cell">
                                <div class="actions-section">
                                    <a href="/mangatheque/mangas/<?= $manga->getId() ?>" 
                                       class="action-link action-view">Voir</a>
                                    <a href="/mangatheque/mangas/<?= $manga->getId() ?>/edit" 
                                       class="action-link action-edit">Éditer</a>
                                    <form action="/mangatheque/mangas/<?= $manga->getId() ?>/delete" 
                                          method="POST" 
                                          class="delete-form" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce manga ?');">
                                        <button type="submit" class="action-delete">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>