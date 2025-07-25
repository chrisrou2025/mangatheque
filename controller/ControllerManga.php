<?php

// Définition de la classe ControllerManga
class ControllerManga
{
    private MangaModel $mangaModel; // Propriété pour stocker l'instance du MangaModel
    private const UPLOAD_DIR = __DIR__ . '/../public/covers/'; // Répertoire d'upload des couvertures

    // Constructeur de la classe
    public function __construct()
    {
        // Crée une instance de MangaModel, qui gérera la connexion à la DB
        $this->mangaModel = new MangaModel();
        // Vérifie et crée le répertoire d'upload si nécessaire
        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0777, true); // 0777 pour des permissions larges, à ajuster en production
        }
    }


    // Gère l'upload d'un fichier image.

    private function handleFileUpload(array $file): string
    {
        // Vérifie si un fichier a été uploadé sans erreur
        if (isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
            // Génère un nom de fichier unique pour éviter les conflits
            $fileName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = self::UPLOAD_DIR . $fileName;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Vérifier si le fichier est une image réelle
            $check = getimagesize($file["tmp_name"]);
            if ($check === false) {
                // Fichier non image
                return 'placeholder.png';
            }

            // Vérifier la taille du fichier (ex: max 5MB)
            if ($file["size"] > 5000000) {
                // Fichier trop grand
                return 'placeholder.png';
            }

            // Autoriser certains formats de fichier
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                // Format non autorisé
                return 'placeholder.png';
            }

            // Tenter de déplacer le fichier uploadé du répertoire temporaire vers le répertoire cible
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                return $fileName; // Retourne le nom du fichier sauvegardé
            }
        }
        // Retourne le placeholder en cas d'erreur, d'absence de fichier ou si les validations échouent
        return 'placeholder.png';
    }


    /**
     * Affiche la liste de tous les mangas.
     * Route: GET /mangas
     */
    public function listMangas(): void
    {
        // Récupère tous les mangas depuis le modèle (qui interagit maintenant avec la DB)
        $mangas = $this->mangaModel->getAll(); // Cette méthode récupère déjà la note moyenne
        // Définit le titre de la page
        $title = "Liste des Mangas";
        // Démarre la capture de la sortie pour inclure la vue
        ob_start();
        // Inclut la vue de la liste des mangas
        require './view/manga/list.php';
        // Récupère le contenu capturé
        $content = ob_get_clean();
        // Inclut le template HTML de base
        require './view/base-html.php';
    }

    /**
     * Affiche le formulaire d'ajout d'un nouveau manga.
     * Route: GET /mangas/create
     */
    public function createMangaForm(): void
    {
        // Définit le titre de la page
        $title = "Ajouter un Manga";
        // Démarre la capture de la sortie pour inclure la vue
        ob_start();
        // Inclut la vue du formulaire d'ajout
        require './view/manga/create.php';
        // Récupère le contenu capturé
        $content = ob_get_clean();
        // Inclut le template HTML de base
        require './view/base-html.php';
    }

    /**
     * Traite la soumission du formulaire d'ajout et ajoute un nouveau manga.
     * Route: POST /mangas/store
     */
    public function storeManga(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $volume = (int)($_POST['volume'] ?? 0);
            $description = $_POST['description'] ?? '';
            $publisher = $_POST['publisher'] ?? '';
            $type = $_POST['type'] ?? 'Shonen'; // AJOUTÉ : récupération du type

            // Gestion de l'upload de l'image de couverture
            $coverImage = $this->handleFileUpload($_FILES['cover_image'] ?? []);

            // Création d'un nouvel objet Manga avec TOUS les paramètres
            $manga = new Manga($title, $author, $volume, $description, $coverImage, $publisher, $type);

            // Ajout du manga via le modèle
            $this->mangaModel->add($manga);

            header('Location: /mangatheque/mangas');
            exit();
        }
        header('Location: /mangatheque/mangas/create');
        exit();
    }

    /**
     * Affiche la fiche détaillée d'un manga.
     * Route: GET /mangas/[i:id]
     */
    public function showManga(array $params): void
    {
        $id = (int)$params['id'];

        try {
            // Récupération du manga avec sa note moyenne
            $manga = $this->mangaModel->getById($id);

            if ($manga) {
                // Vérifier si le manga est en favori pour l'utilisateur connecté
                $isFavorite = false;
                if (isset($_SESSION['id'])) {
                    $isFavorite = $this->mangaModel->isFavorite((int)$_SESSION['id'], $id);
                }

                // Récupération de la note moyenne et des avis
                $averageRating = $manga->getAverageRating();
                $reviews = $this->mangaModel->getReviewsByMangaId($id);

                // Définition du titre et préparation de la vue
                $title = "Fiche de " . $manga->getTitle();

                // Capture de la sortie
                ob_start();
                require './view/manga/show.php';
                $content = ob_get_clean();

                // Inclusion du template de base
                require './view/base-html.php';
            } else {
                // Manga non trouvé
                http_response_code(404);
                $title = "Manga non trouvé";
                $content = "<div class='container mx-auto p-4'><h1 class='text-3xl font-bold text-red-600'>Erreur 404: Manga non trouvé</h1><p class='mt-4'>Le manga que vous recherchez n'existe pas.</p><a href='/mangatheque/mangas' class='mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded'>Retour à la liste</a></div>";
                require './view/base-html.php';
            }
        } catch (Exception $e) {
            // Gestion des erreurs
            error_log("Erreur dans showManga: " . $e->getMessage());
            http_response_code(500);
            $title = "Erreur serveur";
            $content = "<div class='container mx-auto p-4'><h1 class='text-3xl font-bold text-red-600'>Erreur serveur</h1><p class='mt-4'>Une erreur est survenue lors du chargement de la page.</p><a href='/mangatheque/mangas' class='mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded'>Retour à la liste</a></div>";
            require './view/base-html.php';
        }
    }

    /**
     * Affiche le formulaire d'édition d'un manga existant.
     * Route: GET /mangas/[i:id]/edit
     */
    public function editMangaForm(array $params): void
    {
        $id = (int)$params['id']; // Récupère l'ID du manga
        // Récupère le manga par son ID
        $manga = $this->mangaModel->getById($id);

        // Vérifie si le manga existe
        if ($manga) {
            // Définit le titre de la page
            $title = "Modifier " . $manga->getTitle();
            // Démarre la capture de la sortie pour inclure la vue
            ob_start();
            // Inclut la vue du formulaire d'édition
            require './view/manga/edit.php';
            // Récupère le contenu capturé
            $content = ob_get_clean();
            // Inclut le template HTML de base
            require './view/base-html.php';
        } else {
            // Si le manga n'est pas trouvé, renvoie une erreur 404
            http_response_code(404);
            $title = "Manga non trouvé";
            $content = "<h1>Erreur 404: Manga non trouvé</h1><p>Le manga que vous tentez de modifier n'existe pas.</p>";
            require './view/base-html.php';
        }
    }

    /**
     * Traite la soumission du formulaire d'édition et met à jour un manga.
     * Route: POST /mangas/[i:id]/update
     */
    public function updateManga(array $params): void
    {
        $id = (int)$params['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $volume = (int)($_POST['volume'] ?? 0);
            $description = $_POST['description'] ?? '';
            $publisher = $_POST['publisher'] ?? '';
            $type = $_POST['type'] ?? 'Shonen'; // AJOUTÉ : récupération du type

            // Récupération du manga existant pour conserver les valeurs actuelles si non modifiées
            $existingManga = $this->mangaModel->getById($id);

            if (!$existingManga) {
                header('Location: /mangatheque/mangas');
                exit();
            }

            // Conservation des valeurs existantes si les champs sont vides
            if (empty($publisher)) {
                $publisher = $existingManga->getPublisher();
            }

            // AJOUTÉ : Conservation du type existant si non défini
            if (empty($type) || $type === 'Shonen') {
                $type = $existingManga->getType();
            }

            // Gestion de l'image de couverture
            $currentCoverImage = $existingManga->getCoverImage();
            $newCoverImage = $this->handleFileUpload($_FILES['cover_image'] ?? []);
            $coverImageToSave = ($newCoverImage !== 'placeholder.png') ? $newCoverImage : $currentCoverImage;

            if (($newCoverImage !== 'placeholder.png') && ($currentCoverImage !== 'placeholder.png') && file_exists(self::UPLOAD_DIR . $currentCoverImage)) {
                unlink(self::UPLOAD_DIR . $currentCoverImage);
            }

            // Création de l'objet Manga mis à jour avec TOUS les paramètres
            $updatedManga = new Manga(
                $title,
                $author,
                $volume,
                $description,
                $coverImageToSave,
                $publisher,
                $type // AJOUTÉ : inclusion du type
            );
            $updatedManga->setId($id);

            if ($this->mangaModel->update($updatedManga)) {
                header('Location: /mangatheque/mangas/' . $id);
                exit();
            } else {
                header('Location: /mangatheque/mangas');
                exit();
            }
        }
        header('Location: /mangatheque/mangas/' . $id . '/edit');
        exit();
    }
    /**
     * Supprime un manga.
     * Route: POST /mangas/[i:id]/delete
     */
    public function deleteManga(array $params): void
    {
        $id = (int)$params['id']; // Récupère l'ID du manga
        // Vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Avant de supprimer le manga de la DB, récupère son image de couverture
            $mangaToDelete = $this->mangaModel->getById($id);
            if ($mangaToDelete && $mangaToDelete->getCoverImage() !== 'placeholder.png') {
                $filePath = self::UPLOAD_DIR . $mangaToDelete->getCoverImage();
                if (file_exists($filePath)) {
                    unlink($filePath); // Supprime le fichier physique
                }
            }
            // Supprime le manga via le modèle
            $this->mangaModel->delete($id);
        }
        // Redirige vers la liste des mangas après la suppression (ou si ce n'est pas POST)
        header('Location: /mangatheque/mangas');
        exit();
    }

    /**
     * Gère l'ajout/retrait d'un manga des favoris
     * Route: POST /mangas/[i:id]/toggle-favorite
     */
    public function toggleFavorite(array $params): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour ajouter des favoris.";
            header('Location: /mangatheque/login');
            exit();
        }

        $mangaId = (int)$params['id'];
        $userId = (int)$_SESSION['id'];

        // Vérifier que le manga existe
        $manga = $this->mangaModel->getById($mangaId);
        if (!$manga) {
            $_SESSION['error'] = "Le manga demandé n'existe pas.";
            header('Location: /mangatheque/mangas');
            exit();
        }

        // Vérifier si le manga est déjà en favori
        $isFavorite = $this->mangaModel->isFavorite($userId, $mangaId);

        if ($isFavorite) {
            // Retirer des favoris
            if ($this->mangaModel->removeFavorite($userId, $mangaId)) {
                $_SESSION['success'] = "Le manga \"{$manga->getTitle()}\" a été retiré de vos favoris.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression du favori.";
            }
        } else {
            // Ajouter aux favoris
            if ($this->mangaModel->addFavorite($userId, $mangaId)) {
                $_SESSION['success'] = "Le manga \"{$manga->getTitle()}\" a été ajouté à vos favoris.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du favori.";
            }
        }

        // Rediriger vers la fiche du manga
        header('Location: /mangatheque/mangas/' . $mangaId);
        exit();
    }

    /**
     * Affiche la page du top des mangas favoris
     * Route: GET /mangas/top
     */
    public function topFavorites(): void
    {
        // Récupère le top 5 des mangas favoris
        $topMangas = $this->mangaModel->getTopFavorites(5);

        $title = "Top des Mangas Favoris";

        ob_start();
        require './view/manga/top.php';
        $content = ob_get_clean();
        require './view/base-html.php';
    }

    /**
     * Affiche les favoris de l'utilisateur connecté
     * Route: GET /mangas/favorites
     */
    public function myFavorites(): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir vos favoris.";
            header('Location: /mangatheque/login');
            exit();
        }

        $userId = (int)$_SESSION['id'];
        $favoriteMangas = $this->mangaModel->getUserFavorites($userId);

        $title = "Mes Mangas Favoris";

        ob_start();
        require './view/manga/favorites.php';
        $content = ob_get_clean();
        require './view/base-html.php';
    }

    /**
     * Traite la soumission d'un avis (note et commentaire) pour un manga.
     * Route: POST /mangas/[i:id]/review
     */
    public function addReview(array $params): void
    {
        // Débogage : Vérifier les données reçues
        error_log("=== DEBUT addReview ===");
        error_log("POST data: " . print_r($_POST, true));
        error_log("SESSION data: " . print_r($_SESSION, true));

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            error_log("Utilisateur non connecté");
            $_SESSION['error'] = "Vous devez être connecté pour laisser un avis.";
            header('Location: /mangatheque/login');
            exit();
        }

        $mangaId = (int)$params['id'];
        $userId = (int)$_SESSION['id'];
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        error_log("MangaID: $mangaId, UserID: $userId, Rating: $rating");

        // Validation des données
        if ($rating < 1 || $rating > 5) {
            error_log("Rating invalide: $rating");
            $_SESSION['error'] = "La note doit être comprise entre 1 et 5.";
            header('Location: /mangatheque/mangas/' . $mangaId);
            exit();
        }

        // Vérifier que le manga existe
        $manga = $this->mangaModel->getById($mangaId);
        if (!$manga) {
            error_log("Manga non trouvé: $mangaId");
            $_SESSION['error'] = "Le manga n'existe pas.";
            header('Location: /mangatheque/mangas');
            exit();
        }

        // Tenter d'ajouter l'avis
        try {
            $result = $this->mangaModel->addReview($mangaId, $userId, $rating, $comment);

            if ($result) {
                error_log("Avis ajouté avec succès");
                $_SESSION['success'] = "Votre avis a été ajouté avec succès !";
            } else {
                error_log("Échec de l'ajout de l'avis");
                $_SESSION['error'] = "Vous avez déjà laissé un avis pour ce manga ou une erreur est survenue.";
            }
        } catch (Exception $e) {
            error_log("Exception lors de l'ajout de l'avis: " . $e->getMessage());
            $_SESSION['error'] = "Une erreur technique est survenue.";
        }

        error_log("Redirection vers: /mangatheque/mangas/$mangaId");
        error_log("=== FIN addReview ===");

        // Redirection avec un header complet
        header('Location: /mangatheque/mangas/' . $mangaId);
        exit();
    }
}
