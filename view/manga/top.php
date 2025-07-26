<div class="top-container">
    <div class="top-header">
        <h1 class="top-title">🏆 Top des Mangas Favoris</h1>
    </div>

    <?php if (empty($topMangas)): ?>
        <div class="no-favorites-message">
            <div class="message-with-icon">
                <svg class="message-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="message-bold">Aucun manga n'a encore été ajouté aux favoris.</span>
            </div>
            <p class="message-secondary">Soyez le premier à ajouter un manga à vos favoris !</p>
        </div>
    <?php else: ?>
        <div class="top-grid">
            <?php foreach ($topMangas as $index => $item): ?>
                <?php
                $manga = $item['manga'];
                $favoriteCount = $item['favorite_count'];
                $position = $index + 1;

                // Classes pour le podium
                $ringClass = '';
                $gradientClass = '';
                
                switch($position) {
                    case 1:
                        $ringClass = 'ring-gold';
                        $gradientClass = 'gradient-gold';
                        break;
                    case 2:
                        $ringClass = 'ring-silver';
                        $gradientClass = 'gradient-silver';
                        break;
                    case 3:
                        $ringClass = 'ring-bronze';
                        $gradientClass = 'gradient-bronze';
                        break;
                    default:
                        $gradientClass = 'gradient-blue';
                        break;
                }
                ?>

                <div class="manga-card-top <?= $position <= 3 ? $ringClass : '' ?>">
                    <div class="manga-card-flex">
                        <!-- Badge de position -->
                        <div class="image-section">
                            <div class="position-badge">
                                <div class="badge-circle <?= $gradientClass ?>">
                                    <?php if ($position <= 3): ?>
                                        <?= $position === 1 ? '🥇' : ($position === 2 ? '🥈' : '🥉') ?>
                                    <?php else: ?>
                                        <?= $position ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Image du manga -->
                            <div class="image-container">
                                <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>"
                                    alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>"
                                    class="manga-cover-top">
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="content-section">
                            <div class="content-header">
                                <h2 class="manga-title-top">
                                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="manga-link-top">
                                        <?= htmlspecialchars($manga->getTitle()) ?>
                                    </a>
                                </h2>

                                <!-- Compteur de favoris -->
                                <div class="favorites-counter">
                                    <svg class="heart-icon" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="favorites-count"><?= $favoriteCount ?></span>
                                    <span class="favorites-text"><?= $favoriteCount > 1 ? 'favoris' : 'favori' ?></span>
                                </div>
                            </div>

                            <!-- Informations du manga -->
                            <div class="manga-info-top">
                                <div class="info-line">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <strong class="info-label">Auteur:</strong> 
                                    <span class="info-value"><?= htmlspecialchars($manga->getAuthor()) ?></span>
                                </div>

                                <div class="info-line">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <strong class="info-label">Volume:</strong> 
                                    <span class="info-value"><?= htmlspecialchars($manga->getVolume()) ?></span>
                                </div>

                                <div class="info-line">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <strong class="info-label">Éditeur:</strong> 
                                    <span class="info-value"><?= htmlspecialchars($manga->getPublisher()) ?></span>
                                </div>

                                <div class="info-line">
                                    <span class="type-badge-top">
                                        <?= htmlspecialchars($manga->getType()) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="manga-description line-clamp-3">
                                <?= nl2br(htmlspecialchars(substr($manga->getDescription(), 0, 200))) ?>
                                <?= strlen($manga->getDescription()) > 200 ? '...' : '' ?>
                            </p>

                            <!-- Bouton pour voir le manga -->
                            <div class="button-section">
                                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>"
                                    class="view-manga-btn">
                                    Voir le manga
                                    <svg class="btn-arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>