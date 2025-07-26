<div class="favorites-container">
    <div class="favorites-header">
        <h1 class="favorites-title">⭐ Mes Mangas Favoris</h1>
    </div>

    <?php if (empty($favoriteMangas)): ?>
        <div class="no-favorites-message">
            <div class="favorites-message-with-icon">
                <svg class="favorites-message-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <p class="favorites-message-bold">Vous n'avez pas encore ajouté de mangas à vos favoris.</p>
            </div>
            <p class="favorites-message-secondary">Parcourez la <a href="/mangatheque/mangas" class="favorites-message-link">liste des mangas</a> pour trouver vos préférés !</p>
        </div>
    <?php else: ?>
        <div class="favorites-grid">
            <?php foreach ($favoriteMangas as $manga): ?>
                <div class="favorite-manga-card">
                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="favorite-manga-link">
                        <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="favorite-manga-cover">
                        <div class="favorite-manga-info">
                            <h3 class="favorite-manga-title"><?= htmlspecialchars($manga->getTitle()) ?></h3>
                            <p class="favorite-manga-volume">Vol. <?= htmlspecialchars($manga->getVolume()) ?></p>
                            <p class="favorite-manga-author">Par <?= htmlspecialchars($manga->getAuthor()) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>