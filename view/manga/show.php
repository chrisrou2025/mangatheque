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
    echo '<div class="max-w-2xl mx-auto mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">';
    echo htmlspecialchars($_SESSION['success']);
    echo '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="max-w-2xl mx-auto mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">';
    echo htmlspecialchars($_SESSION['error']);
    echo '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Fiche détaillée du Manga</h1>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg flex flex-col md:flex-row items-center md:items-start">
        <div class="md:mr-8 mb-6 md:mb-0">
            <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>" class="w-48 h-72 object-cover rounded-lg shadow-md">
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars($manga->getTitle()) ?></h2>

            <div class="mb-3">
                <strong class="text-gray-700">Type:</strong> <?= htmlspecialchars($manga->getType()) ?>
            </div>
            <div class="mb-3">
                <strong class="text-gray-700">Auteur:</strong> <?= htmlspecialchars($manga->getAuthor()) ?>
            </div>
            <div class="mb-3">
                <strong class="text-gray-700">Volume:</strong> <?= htmlspecialchars($manga->getVolume()) ?>
            </div>
            <div class="mb-3">
                <strong class="text-gray-700">Éditeur:</strong> <?= htmlspecialchars($manga->getPublisher()) ?>
            </div>
            <div class="mb-4">
                <strong class="text-gray-700">Description:</strong>
                <p class="text-gray-600 mt-1"><?= nl2br(htmlspecialchars($manga->getDescription())) ?></p>
            </div>

            <?php if (isset($_SESSION['id'])): // Afficher le bouton seulement si l'utilisateur est connecté ?>
                <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/toggle-favorite" method="POST" class="mb-4">
                    <button type="submit" class="w-full md:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <?php if ($isFavorite): ?>
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            Retirer des favoris
                        <?php else: ?>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Ajouter aux favoris
                        <?php endif; ?>
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-semibold mb-4">Laisser une note et un commentaire</h3>
                    <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/review" method="POST" class="space-y-4">
                        <div>
                            <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Note (1-5):</label>
                            <select name="rating" id="rating" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">-- Choisir une note --</option>
                                <option value="1">1 étoile</option>
                                <option value="2">2 étoiles</option>
                                <option value="3">3 étoiles</option>
                                <option value="4">4 étoiles</option>
                                <option value="5">5 étoiles</option>
                            </select>
                        </div>
                        <div>
                            <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Commentaire:</label>
                            <textarea name="comment" id="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Écrivez votre commentaire ici..."></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Envoyer l'avis
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="max-w-2xl mx-auto mt-8 bg-white p-8 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Avis des utilisateurs</h3>

        <?php if ($averageRating !== null): ?>
            <div class="mb-6">
                <p class="text-gray-700 text-lg font-bold">Note moyenne:
                    <span class="text-blue-600"><?= number_format($averageRating, 1) ?> / 5</span>
                    (<?= count($reviews) ?> avis)
                </p>
                <div class="flex items-center mt-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-5 h-5 <?= $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mb-4">Aucune note n'a encore été attribuée à ce manga.</p>
        <?php endif; ?>

        <?php if (empty($reviews)): ?>
            <p class="text-gray-600">Aucun commentaire pour le moment. Soyez le premier à laisser un avis !</p>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($reviews as $review): ?>
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <div class="flex items-center mb-2">
                            <p class="font-semibold text-gray-800 mr-2">
                                <?php 
                                // Gestion compatible pour les deux formats (objet Review ou stdClass)
                                if (isset($review->username)) {
                                    echo htmlspecialchars($review->username);
                                } elseif (method_exists($review, 'getUsername')) {
                                    echo htmlspecialchars($review->getUsername());
                                } else {
                                    echo "Utilisateur inconnu";
                                }
                                ?>
                            </p>
                            <div class="flex">
                                <?php 
                                $rating = isset($review->rating) ? $review->rating : 
                                         (method_exists($review, 'getRating') ? $review->getRating() : 0);
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <svg class="w-4 h-4 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.532 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.777.565-1.832-.197-1.532-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="ml-2 text-sm text-gray-500">
                                <?php 
                                $createdAt = isset($review->created_at) ? $review->created_at : 
                                           (method_exists($review, 'getCreatedAt') ? $review->getCreatedAt() : '');
                                if ($createdAt) {
                                    echo htmlspecialchars((new DateTime($createdAt))->format('d/m/Y'));
                                }
                                ?>
                            </span>
                        </div>
                        <p class="text-gray-700">
                            <?php 
                            $comment = isset($review->comment) ? $review->comment : 
                                     (method_exists($review, 'getComment') ? $review->getComment() : '');
                            echo nl2br(htmlspecialchars($comment));
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>