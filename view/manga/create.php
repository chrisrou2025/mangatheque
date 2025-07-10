<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center mb-6">Ajouter un nouveau Manga</h1>
    <form action="/mangatheque/mangas/store" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre:</label>
            <input type="text" id="title" name="title" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="author" class="block text-gray-700 text-sm font-bold mb-2">Auteur:</label>
            <input type="text" id="author" name="author" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="volume" class="block text-gray-700 text-sm font-bold mb-2">Volume:</label>
            <input type="number" id="volume" name="volume" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea id="description" name="description" rows="4" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"></textarea>
        </div>

        <div class="mb-4">
            <label for="publisher" class="block text-gray-700 text-sm font-bold mb-2">Maison d'édition:</label>
            <input type="text" id="publisher" name="publisher" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Image de couverture:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
                Ajouter le Manga
            </button>
            <a href="/mangatheque/mangas" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Annuler
            </a>
        </div>
    </form>
</div>