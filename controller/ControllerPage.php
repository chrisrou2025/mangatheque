<?php
// Inclusion du modèle MangaModel pour interagir avec les données des mangas
require_once 'model/MangaModel.php';

// Définition de la classe ControllerPage
class ControllerPage {
    private MangaModel $mangaModel; // Propriété pour stocker l'instance du MangaModel

    // Constructeur de la classe
    public function __construct()
    {
        // Crée une instance de MangaModel pour accéder aux données de la base de données
        $this->mangaModel = new MangaModel();
    }

    /**
     * Affiche la page d'accueil.
     * Cette méthode récupère tous les mangas pour les afficher sur la page d'accueil.
     */
    public function homePage() {
        // Récupère tous les mangas depuis le modèle
        $mangas = $this->mangaModel->getAll();

        // Définit le titre de la page
        $title = "Bienvenue dans Ma Mangathèque";

        // Démarre la capture de la sortie pour inclure la vue
        ob_start();
        // Inclut la vue de la page d'accueil, en lui passant la variable $mangas
        require './view/page/homepage.php';
        // Récupère le contenu capturé
        $content = ob_get_clean();

        // Inclut le template HTML de base, qui affichera le $content
        require './view/base-html.php';
    }
}
