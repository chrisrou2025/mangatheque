<?php
// Assure que $manga est défini
if (!isset($manga)) {
    // Redirige ou affiche une erreur si le manga n'est pas passé
    header('Location: /mangatheque/mangas');
    exit();
}

$averageRating = $averageRating ?? null;
$reviews = $reviews ?? [];

// Affichage des messages de succès/erreur
if (isset($_SESSION['success'])) {
    echo '<div class="message-success">';
    echo htmlspecialchars($_SESSION['success']);
    echo '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="message-error">';
    echo htmlspecialchars($_SESSION['error']);
    echo '</div>';
    unset($_SESSION['error']);
}
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
                            <svg class="favorites-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            Retirer des favoris
                        <?php else: ?>
                            <svg class="favorites-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
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
                        <svg class="average-star <?= $i <= round($averageRating) ? 'average-star-gold' : 'average-star-gray' ?>"
                            viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
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
                                    <svg class="review-star <?= $i <= $rating ? 'review-star-gold' : 'review-star-gray' ?>"
                                        viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                                    </svg>
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