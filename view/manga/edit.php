<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center mb-6">Modifier le Manga: <?= htmlspecialchars($manga->getTitle()) ?></h1>
    <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/update" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($manga->getTitle()) ?>" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="author" class="block text-gray-700 text-sm font-bold mb-2">Auteur:</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($manga->getAuthor()) ?>" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="volume" class="block text-gray-700 text-sm font-bold mb-2">Volume:</label>
            <input type="number" id="volume" name="volume" value="<?= htmlspecialchars($manga->getVolume()) ?>" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <!-- Nouveau champ pour le type de manga avec la valeur actuelle sélectionnée -->
        <div class="mb-4">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type de manga:</label>
            <select id="type" name="type" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                <option value="">Sélectionnez un type</option>
                <option value="Shonen" <?= $manga->getType() === 'Shonen' ? 'selected' : '' ?>>Shōnen</option>
                <option value="Kodomo" <?= $manga->getType() === 'Kodomo' ? 'selected' : '' ?>>Kodomo</option>
                <option value="Shôjo" <?= $manga->getType() === 'Shôjo' ? 'selected' : '' ?>>Shôjo</option>
                <option value="Seinen" <?= $manga->getType() === 'Seinen' ? 'selected' : '' ?>>Seinen</option>
                <option value="Josei" <?= $manga->getType() === 'Josei' ? 'selected' : '' ?>>Josei</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea id="description" name="description" rows="4" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"><?= htmlspecialchars($manga->getDescription()) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="publisher" class="block text-gray-700 text-sm font-bold mb-2">Maison d'édition:</label>
            <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($manga->getPublisher()) ?>" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Image de couverture actuelle:</label>
            <?php if ($manga->getCoverImage() && $manga->getCoverImage() !== 'placeholder.png'): ?>
                <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture actuelle" class="w-32 h-auto mb-4 rounded-lg shadow-md">
            <?php else: ?>
                <p class="text-gray-600 mb-4">Aucune image de couverture actuelle.</p>
            <?php endif; ?>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle.</p>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
                Mettre à jour le Manga
            </button>
            <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Annuler
            </a>
        </div>
    </form>
</div>