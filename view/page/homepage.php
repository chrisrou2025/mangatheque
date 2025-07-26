<?php
// Assurez-vous que $mangas est défini et est un tableau
if (!isset($mangas) || !is_array($mangas)) {
    $mangas = []; // Initialise un tableau vide si $mangas n'est pas défini
}
?>

<div class="homepage-container">
    <h1 class="homepage-title">Découvrez La Mangathèque</h1>

    <?php if (empty($mangas)): ?>
        <div class="empty-collection">
            <p class="empty-message">Il n'y a pas encore de mangas dans votre collection.</p>
            <a href="/mangatheque/mangas/create" class="btn-add-first-manga">
                Ajouter votre premier manga !
            </a>
        </div>
    <?php else: ?>
        <h2 class="recent-mangas-title">Mangas Récemment Ajoutés</h2>
        <div class="mangas-grid">
            <?php foreach ($mangas as $manga): ?>
                <div class="manga-card">
                    <a href="/mangatheque/mangas/<?= $manga->getId() ?>" class="manga-link">
                        <img src="/mangatheque/public/covers/<?= $manga->getCoverImage() ?>" alt="Couverture de <?= $manga->getTitle() ?>" class="manga-cover">
                        <div class="manga-info">
                            <h3 class="manga-title"><?= $manga->getTitle() ?></h3>
                            <p class="manga-volume">Vol. <?= $manga->getVolume() ?></p>
                            <p class="manga-author">Par <?= $manga->getAuthor() ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>