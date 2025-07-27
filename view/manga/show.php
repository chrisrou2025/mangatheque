<?php
// Assure que $manga est défini
if (!isset($manga)) {
    // Redirige ou affiche une erreur si le manga n'est pas passé
    header('Location: /mangatheque/mangas');
    exit();
}

$averageRating = $averageRating ?? null;
$reviews = $reviews ?? [];
?>

<div class="show-container">
    <h1 class="show-title">Fiche détaillée du Manga</h1>

    <div class="manga-card-detail">
        <div class="image-section-detail">
            <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>"
                alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>"
                class="manga-cover-detail">
        </div>
        <div class="content-section-detail">
            <h2 class="manga-title-detail"><?= htmlspecialchars($manga->getTitle()) ?></h2>

            <div class="info-line-detail">
                <strong class="info-label-detail">Type:</strong> <?= htmlspecialchars($manga->getType()) ?>
            </div>
            <div class="info-line-detail">
                <strong class="info-label-detail">Auteur:</strong> <?= htmlspecialchars($manga->getAuthor()) ?>
            </div>
            <div class="info-line-detail">
                <strong class="info-label-detail">Volume:</strong> <?= htmlspecialchars($manga->getVolume()) ?>
            </div>
            <div class="info-line-detail">
                <strong class="info-label-detail">Éditeur:</strong> <?= htmlspecialchars($manga->getPublisher()) ?>
            </div>
            <div class="info-line-detail">
                <strong class="info-label-detail">Description:</strong>
                <p class="description-text"><?= nl2br(htmlspecialchars($manga->getDescription())) ?></p>
            </div>

            <?php if (isset($_SESSION['id'])): // Afficher le bouton seulement si l'utilisateur est connecté 
            ?>
                <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/toggle-favorite"
                    method="POST"
                    class="favorites-form">
                    <button type="submit" class="favorites-btn">
                        <?php if ($isFavorite): ?>
                            <span class="favorites-heart-icon">❤️</span>
                            Retirer des favoris
                        <?php else: ?>
                            <span class="favorites-heart-icon">🤍</span>
                            Ajouter aux favoris
                        <?php endif; ?>
                    </button>
                </form>

                <div class="review-section">
                    <h3 class="review-title">Laisser une note et un commentaire</h3>
                    <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/review"
                        method="POST"
                        class="review-form">
                        <div class="form-group-detail">
                            <label for="rating" class="form-label-detail">Note (1-5):</label>
                            <select name="rating" id="rating" class="form-select-detail" required>
                                <option value="">-- Choisir une note --</option>
                                <option value="1">1 étoile</option>
                                <option value="2">2 étoiles</option>
                                <option value="3">3 étoiles</option>
                                <option value="4">4 étoiles</option>
                                <option value="5">5 étoiles</option>
                            </select>
                        </div>
                        <div class="form-group-detail">
                            <label for="comment" class="form-label-detail">Commentaire:</label>
                            <textarea name="comment"
                                id="comment"
                                rows="4"
                                class="form-textarea-detail"
                                placeholder="Écrivez votre commentaire ici..."></textarea>
                        </div>
                        <button type="submit" class="submit-review-btn">
                            Envoyer l'avis
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="reviews-card">
        <h3 class="reviews-title">Avis des utilisateurs</h3>

        <?php if ($averageRating !== null): ?>
            <div class="average-rating-section">
                <p class="average-rating-text">Note moyenne:
                    <span class="rating-value"><?= number_format($averageRating, 1) ?> / 5</span>
                    (<?= count($reviews) ?> avis)
                </p>
                <div class="average-stars-container">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star-unicode <?= $i <= round($averageRating) ? 'star-filled' : 'star-empty' ?>">★</span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="no-rating-message">Aucune note n'a encore été attribuée à ce manga.</p>
        <?php endif; ?>

        <?php if (empty($reviews)): ?>
            <p class="no-comments-message">Aucun commentaire pour le moment. Soyez le premier à laisser un avis !</p>
        <?php else: ?>
            <div class="reviews-container">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <div class="review-header">
                            <p class="review-username">
                                <?php
                                // Vérifie si l'objet $review a une propriété pseudo ou une méthode getPseudo
                                // et affiche le pseudo de l'utilisateur
                                if (isset($review->pseudo)) {
                                    echo htmlspecialchars($review->pseudo);
                                } elseif (method_exists($review, 'getPseudo')) {
                                    echo htmlspecialchars($review->getPseudo());
                                } else {
                                    echo "Utilisateur inconnu";
                                }
                                ?>
                            </p>
                            <div class="review-stars">
                                <?php
                                $rating = isset($review->rating) ? $review->rating : (method_exists($review, 'getRating') ? $review->getRating() : 0);
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <span class="star-unicode <?= $i <= $rating ? 'star-filled' : 'star-empty' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <span class="review-date">
                                <?php
                                $createdAt = isset($review->created_at) ? $review->created_at : (method_exists($review, 'getCreatedAt') ? $review->getCreatedAt() : '');
                                if ($createdAt) {
                                    echo htmlspecialchars((new DateTime($createdAt))->format('d/m/Y'));
                                }
                                ?>
                            </span>
                        </div>
                        <p class="review-comment">
                            <?php
                            $comment = isset($review->comment) ? $review->comment : (method_exists($review, 'getComment') ? $review->getComment() : '');
                            echo nl2br(htmlspecialchars($comment));
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php

// 📱 Section JavaScript pour gérer les notifications avec showToast
if (isset($_SESSION['success'])) {
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'showToast("' . addslashes($_SESSION['success']) . '", "success");';
    echo '});';
    echo '</script>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'showToast("' . addslashes($_SESSION['error']) . '", "error");';
    echo '});';
    echo '</script>';
    unset($_SESSION['error']);
}
?>