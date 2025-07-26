<div class="edit-container">
    <h1 class="edit-title">Modifier le Manga: <?= htmlspecialchars($manga->getTitle()) ?></h1>
    <form action="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>/update" method="POST" enctype="multipart/form-data" class="edit-form-container">
        <div class="form-group-edit">
            <label for="title" class="form-label-edit">Titre:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($manga->getTitle()) ?>" required class="form-input-edit">
        </div>

        <div class="form-group-edit">
            <label for="author" class="form-label-edit">Auteur:</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($manga->getAuthor()) ?>" required class="form-input-edit">
        </div>

        <div class="form-group-edit">
            <label for="volume" class="form-label-edit">Volume:</label>
            <input type="number" id="volume" name="volume" value="<?= htmlspecialchars($manga->getVolume()) ?>" required class="form-input-edit">
        </div>

        <div class="form-group-edit">
            <label for="type" class="form-label-edit">Type de manga:</label>
            <select id="type" name="type" required class="form-select-edit">
                <option value="">Sélectionnez un type</option>
                <option value="Shonen" <?= $manga->getType() === 'Shonen' ? 'selected' : '' ?>>Shōnen</option>
                <option value="Kodomo" <?= $manga->getType() === 'Kodomo' ? 'selected' : '' ?>>Kodomo</option>
                <option value="Shôjo" <?= $manga->getType() === 'Shôjo' ? 'selected' : '' ?>>Shôjo</option>
                <option value="Seinen" <?= $manga->getType() === 'Seinen' ? 'selected' : '' ?>>Seinen</option>
                <option value="Josei" <?= $manga->getType() === 'Josei' ? 'selected' : '' ?>>Josei</option>
            </select>
        </div>

        <div class="form-group-edit">
            <label for="description" class="form-label-edit">Description:</label>
            <textarea id="description" name="description" rows="4" class="form-textarea-edit"><?= htmlspecialchars($manga->getDescription()) ?></textarea>
        </div>

        <div class="form-group-edit">
            <label for="publisher" class="form-label-edit">Maison d'édition:</label>
            <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($manga->getPublisher()) ?>" class="form-input-edit">
        </div>

        <div class="form-group-edit-large">
            <label for="cover_image" class="form-label-edit">Image de couverture actuelle:</label>
            <?php if ($manga->getCoverImage() && $manga->getCoverImage() !== 'placeholder.png'): ?>
                <img src="/mangatheque/public/covers/<?= htmlspecialchars($manga->getCoverImage()) ?>" alt="Couverture actuelle" class="current-cover-image">
            <?php else: ?>
                <p class="no-image-message">Aucune image de couverture actuelle.</p>
            <?php endif; ?>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="form-file-edit">
            <p class="file-help-text">Laissez vide pour conserver l'image actuelle.</p>
        </div>

        <div class="form-buttons-section-edit">
            <button type="submit" class="submit-btn-edit">
                Mettre à jour le Manga
            </button>
            <a href="/mangatheque/mangas/<?= htmlspecialchars($manga->getId()) ?>" class="cancel-link-edit">
                Annuler
            </a>
        </div>
    </form>
</div>