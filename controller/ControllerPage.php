<?php

// Définition de la classe ControllerPage
class ControllerPage
{
    private MangaModel $mangaModel; // Propriété pour stocker l'instance du MangaModel
    private ModelUser $modelUser;   // Propriété pour stocker l'instance du ModelUser

    // Constructeur de la classe
    public function __construct()
    {
        // Crée une instance de MangaModel pour accéder aux données de la base de données
        $this->mangaModel = new MangaModel();
        // Crée une instance de ModelUser pour accéder aux données des utilisateurs
        $this->modelUser = new ModelUser();
    }

    /**
     * Affiche la page d'accueil.
     * Cette méthode récupère tous les mangas et tous les utilisateurs pour les afficher sur la page d'accueil.
     */
    public function homePage()
    {
        if(!isset($_SESSION['id'])) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /mangatheque/login');
            exit();
        }
        $mangas = $this->mangaModel->getAll();
        $users = $this->modelUser->getUsers();
        $title = "Bienvenue dans Ma Mangathèque";

        // Démarre la capture de la sortie
        ob_start();
        // Inclut la vue homepage.php
        require './view/page/homepage.php';
        // Récupère le contenu capturé dans $content
        $content = ob_get_clean();
        // Inclut le template de base
        require './view/base-html.php';
    }
}
