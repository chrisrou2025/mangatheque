<div class="container mx-auto p-4">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">🏆 Top des Mangas Favoris</h1>
    </div>

    <?php if (empty($topMangas)): ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg text-center">
            <div class="flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="font-medium">Aucun manga n'a encore été ajouté aux favoris.</span>
            </div>
            <p class="mt-2">Soyez le premier à ajouter un manga à vos favoris !</p>
        </div>
    <?php else: ?>
        <div class="grid gap-6 md:gap-8">
            <?php foreach ($topMangas as $index => $item): ?>
                <?php
                $manga = $item['manga'];
                $favoriteCount = $item['favorite_count'];
                $position = $index + 1;

                // Couleurs pour le podium
                $podiumColors = [
                    1 => 'from-yellow-400 to-yellow-600', // Or
                    2 => 'from-gray-300 to-gray-500',     // Argent
                    3 => 'from-orange-400 to-orange-600'  // Bronze
                ];
                $gradientClass = $podiumColors[$position] ?? 'from-blue-400 to-blue-600';
                ?>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 <?= $position <= 3 ? 'ring-2 ring-opacity-50 ring-' . ($position === 1 ? 'yellow' : ($position === 2 ? 'gray' : 'orange')) . '-400' : '' ?>">
                    <div class="flex flex-col md:flex-row">
                        <!-- Badge de position -->
                        <div class="relative">
                            <div class="absolute top-4 left-4 z-10">
                                <div class="bg-gradient-to-r <?= $gradientClass ?> text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg shadow-lg">
                                    <?php if ($position <= 3): ?>
                                        <?= $position === 1 ? '🥇' : ($position === 2 ? '🥈' : '🥉') ?>
                                    <?php else: ?>
                                        <?= $position ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Image du manga -->
                            <div class="md:w-48 w-full">
                                <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>"
                                    alt="Couverture de <?= htmlspecialchars($manga->getTitle()) ?>"
                                    class="w-full h-64 md:h-80 object-cover">
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h2 class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition-colors">
                                    <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>">
                                        <?= htmlspecialchars($manga->getTitle()) ?>
                                    </a>
                                </h2>

                                <!-- Compteur de favoris -->
                                <div class="flex items-center bg-red-100 text-red-800 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold"><?= $favoriteCount ?></span>
                                    <span class="ml-1 text-sm"><?= $favoriteCount > 1 ? 'favoris' : 'favori' ?></span>
                                </div>
                            </div>

                            <!-- Informations du manga -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <strong>Auteur:</strong> <span class="ml-1"><?= htmlspecialchars($manga->getAuthor()) ?></span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <strong>Volume:</strong> <span class="ml-1"><?= htmlspecialchars($manga->getVolume()) ?></span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <strong>Éditeur:</strong> <span class="ml-1"><?= htmlspecialchars($manga->getPublisher()) ?></span>
                                </div>

                                <div class="flex items-center">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <?= htmlspecialchars($manga->getType()) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-700 leading-relaxed mb-4 line-clamp-3">
                                <?= nl2br(htmlspecialchars(substr($manga->getDescription(), 0, 200))) ?>
                                <?= strlen($manga->getDescription()) > 200 ? '...' : '' ?>
                            </p>

                            <!-- Bouton pour voir le manga -->
                            <div class="flex justify-end">
                                <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                                    Voir le manga
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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