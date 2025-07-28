<div class="top-container">
    <div class="top-header">
        <h1 class="top-title">🏆 Top des Mangas Favoris</h1>
    </div>

    <?php if (empty($topMangas)): ?>
        <div class="no-favorites-message">
            <div class="message-with-icon">
                <span class="message-icon">⚠️</span>
                <div class="message-content">
                    <span class="message-bold">Aucun manga n'a encore été ajouté aux favoris.</span>
                    <p class="message-secondary">Soyez le premier à ajouter un manga à vos favoris !</p>
                </div>
            </div>
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

                switch ($position) {
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
                                    <span class="badge-emoji">
                                        <?php if ($position <= 3): ?>
                                            <?= $position === 1 ? '🥇' : ($position === 2 ? '🥈' : '🥉') ?>
                                        <?php else: ?>
                                            <?= $position ?>
                                        <?php endif; ?>
                                    </span>
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
                                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>"
                                        class="manga-link-top">
                                        <?= htmlspecialchars($manga->getTitle()) ?>
                                    </a>
                                </h2>

                                <!-- Compteur de favoris -->
                                <div class="favorites-counter">
                                    <span class="heart-icon">❤️</span>
                                    <div class="favorites-text-group">
                                        <span class="favorites-count"><?= $favoriteCount ?></span>
                                        <span class="favorites-text"><?= $favoriteCount > 1 ? 'favoris' : 'favori' ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="manga-info-top">
                                <div class="info-line">
                                    <span class="info-icon">👤</span>
                                    <div class="info-content">
                                        <strong class="info-label">Auteur:</strong>
                                        <span class="info-value"><?= htmlspecialchars($manga->getAuthor()) ?></span>
                                    </div>
                                </div>

                                <div class="info-line">
                                    <span class="info-icon">📚</span>
                                    <div class="info-content">
                                        <strong class="info-label">Volume:</strong>
                                        <span class="info-value"><?= htmlspecialchars($manga->getVolume()) ?></span>
                                    </div>
                                </div>

                                <div class="info-line">
                                    <span class="info-icon">🏢</span>
                                    <div class="info-content">
                                        <strong class="info-label">Éditeur:</strong>
                                        <span class="info-value"><?= htmlspecialchars($manga->getPublisher()) ?></span>
                                    </div>
                                </div>

                                <div class="info-line">
                                    <span class="info-icon">📖</span>
                                    <div class="info-content">
                                        <strong class="info-label">Type:</strong>
                                        <span class="type-badge-top">
                                            <span class="info-value"><?= htmlspecialchars($manga->getType()) ?></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="manga-description line-clamp-3">
                                <?= nl2br(htmlspecialchars(substr($manga->getDescription(), 0, 200))) ?>
                                <?= strlen($manga->getDescription()) > 200 ? '...' : '' ?>
                            </p>

                            <!-- Bouton de vue -->
                            <div class="button-section">
                                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>"
                                    class="view-manga-btn">
                                    <span class="btn-text">Voir le manga</span>
                                    <span class="btn-arrow-icon">▶️</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>