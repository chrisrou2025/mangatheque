<?php
session_start();
// Inclut le fichier de configuration
require __DIR__ . '/vendor/autoload.php';

// Crée une nouvelle instance d'AltoRouter
$router = new AltoRouter();
// Définit le chemin de base de l'application
$router->setBasePath('/mangatheque');

// --- Définition des routes ---

// Route pour la page d'accueil
$router->map('GET', '/', 'ControllerPage#homePage', 'homepage');

// MANGAS
// GET /mangas → Liste de tous les mangas
$router->map('GET', '/mangas', 'ControllerManga#listMangas', 'mangas_list');
// GET /mangas/create → Formulaire d'ajout
$router->map('GET', '/mangas/create', 'ControllerManga#createMangaForm', 'mangas_create_form');
// POST /mangas/store → Traitement d'ajout
$router->map('POST', '/mangas/store', 'ControllerManga#storeManga', 'mangas_store');
// GET /mangas/[i:id] → Fiche d'un manga
$router->map('GET', '/mangas/[i:id]', 'ControllerManga#showManga', 'mangas_show');
// GET /mangas/[i:id]/edit → Formulaire d'édition
$router->map('GET', '/mangas/[i:id]/edit', 'ControllerManga#editMangaForm', 'mangas_edit_form');
// POST /mangas/[i:id]/update → Traitement de modification
$router->map('POST', '/mangas/[i:id]/update', 'ControllerManga#updateManga', 'mangas_update');
// POST /mangas/[i:id]/delete → Suppression d'un manga
$router->map('POST', '/mangas/[i:id]/delete', 'ControllerManga#deleteManga', 'mangas_delete');
// GET /mangas/covers/[*:filename] → Affichage des images de couverture
$router->map('GET', '/mangas/covers/[*:filename]', 'ControllerManga#getCoverImage', 'mangas_cover');

// FAVORIS
$router->map('POST', '/mangas/[i:id]/toggle-favorite', 'ControllerManga#toggleFavorite', 'mangas_toggle_favorite');
$router->map('GET', '/mangas/top', 'ControllerManga#topFavorites', 'mangas_top');
$router->map('GET', '/mangas/favorites', 'ControllerManga#myFavorites', 'user_favorites');

// AVIS
$router->map('POST', '/mangas/[i:id]/review', 'ControllerManga#addReview', 'mangas_add_review');


// User
$router->map('GET', '/user/[i:id]', 'ControllerUser#oneUserById', 'userPage');
$router->map('GET', '/user/delete/[i:id]', 'ControllerUser#deleteUserById', 'userDelete');
$router->map('GET|POST', '/user/update/[i:id]', 'ControllerUser#updateUser', 'userUpdate');

// LOGIN REGISTER LOGOUT

$router->map('GET|POST', '/register', 'ControllerAuth#register', 'register');
$router->map('GET|POST', '/login', 'ControllerAuth#login', 'login');
$router->map('GET', '/logout', 'ControllerAuth#logout', 'logout');

// Cherche une correspondance pour l'URL actuelle
$match = $router->match();

// Vérifie si une route correspondante a été trouvée
if (is_array($match)) {
    // Extrait le contrôleur et l'action de la cible
    list($controller, $action) = explode('#', $match['target']);
    // Crée une nouvelle instance du contrôleur
    $obj = new $controller();

    // Vérifie si la méthode d'action existe dans le contrôleur
    if (is_callable(array($obj, $action))) {
        // Appelle la méthode d'action avec les paramètres de la route
        call_user_func_array(array($obj, $action), array($match['params']));
    } else {
        // Si la méthode n'est pas appelable, renvoie une erreur 404
        http_response_code(404);
        echo "Erreur : Action non trouvée dans le contrôleur.";
    }
} else {
    // Si aucune route ne correspond, renvoie une erreur 404
    http_response_code(404);
    echo "Erreur 404 : Page non trouvée.";
}
