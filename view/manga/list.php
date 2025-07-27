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
                                                <span class="star-unicode <?= $i <= round($manga->getAverageRating()) ? 'star-filled' : 'star-empty' ?>">★</span>
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