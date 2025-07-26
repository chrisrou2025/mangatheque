<div class="create-container">
    <h1 class="create-title">Ajouter un nouveau Manga</h1>
    <form action="/mangatheque/mangas/store" method="POST" enctype="multipart/form-data" class="create-form-container">
        <div class="form-group-create">
            <label for="title" class="form-label-create">Titre:</label>
            <input type="text" id="title" name="title" required class="form-input-create">
        </div>

        <div class="form-group-create">
            <label for="author" class="form-label-create">Auteur:</label>
            <input type="text" id="author" name="author" required class="form-input-create">
        </div>

        <div class="form-group-create">
            <label for="volume" class="form-label-create">Volume:</label>
            <input type="number" id="volume" name="volume" required class="form-input-create">
        </div>

        <div class="form-group-create">
            <label for="type" class="form-label-create">Type de manga:</label>
            <select id="type" name="type" required class="form-select-create">
                <option value="">Sélectionnez un type</option>
                <option value="Shonen">Shōnen</option>
                <option value="Kodomo">Kodomo</option>
                <option value="Shôjo">Shôjo</option>
                <option value="Seinen">Seinen</option>
                <option value="Josei">Josei</option>
            </select>
        </div>

        <div class="form-group-create">
            <label for="description" class="form-label-create">Description:</label>
            <textarea id="description" name="description" rows="4" class="form-textarea-create"></textarea>
        </div>

        <div class="form-group-create">
            <label for="publisher" class="form-label-create">Maison d'édition:</label>
            <input type="text" id="publisher" name="publisher" class="form-input-create">
        </div>

        <div class="form-group-create-large">
            <label for="cover_image" class="form-label-create">Image de couverture:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="form-file-create">
        </div>

        <div class="form-buttons-section">
            <button type="submit" class="submit-btn-create">
                Ajouter le Manga
            </button>
            <a href="/mangatheque/mangas" class="cancel-link-create">
                Annuler
            </a>
        </div>
    </form>
</div>