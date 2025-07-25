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
        $mangas = $this->mangaModel->getAll();
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
        // Vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données du formulaire
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $volume = (int)($_POST['volume'] ?? 0);
            $description = $_POST['description'] ?? '';
            $publisher = $_POST['publisher'] ?? ''; // <-- AJOUTÉ : Récupère le champ publisher

            // Gère l'upload de l'image de couverture
            $coverImage = $this->handleFileUpload($_FILES['cover_image'] ?? []);

            // Crée un nouvel objet Manga avec l'image de couverture et le publisher
            $manga = new Manga($title, $author, $volume, $description, $coverImage, $publisher); // <-- MODIFIÉ : Ajout de $publisher
            // Ajoute le manga via le modèle (qui interagit maintenant avec la DB)
            $this->mangaModel->add($manga);

            // Redirige l'utilisateur vers la liste des mangas
            header('Location: /mangatheque/mangas');
            exit();
        }
        // Si la méthode n'est pas POST, redirige vers le formulaire d'ajout
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
        $manga = $this->mangaModel->getById($id);

        if ($manga) {
            // Vérifier si le manga est en favori pour l'utilisateur connecté
            $isFavorite = false;
            if (isset($_SESSION['id'])) {
                $isFavorite = $this->mangaModel->isFavorite((int)$_SESSION['id'], $id);
            }

            $title = "Fiche de " . $manga->getTitle();
            ob_start();
            require './view/manga/show.php';
            $content = ob_get_clean();
            require './view/base-html.php';
        } else {
            http_response_code(404);
            $title = "Manga non trouvé";
            $content = "<h1>Erreur 404: Manga non trouvé</h1><p>Le manga que vous recherchez n'existe pas.</p>";
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
        $id = (int)$params['id']; // Récupère l'ID du manga
        // Vérifie si la méthode de requête est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données du formulaire
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $volume = (int)($_POST['volume'] ?? 0);
            $description = $_POST['description'] ?? '';
            $publisher = $_POST['publisher'] ?? ''; // <-- AJOUTÉ : Récupère le champ publisher

            // Récupère le manga existant pour conserver les valeurs actuelles si non modifiées
            $existingManga = $this->mangaModel->getById($id);

            if (!$existingManga) {
                // Gérer le cas où le manga n'existe pas
                header('Location: /mangatheque/mangas');
                exit();
            }

            // Gestion de la maison d'édition (publisher) : si le champ est vide dans le formulaire,
            // conserve l'ancienne valeur du manga existant.
            if (empty($publisher)) {
                $publisher = $existingManga->getPublisher();
            }

            // Gestion de l'image de couverture
            $currentCoverImage = $existingManga->getCoverImage(); // Image actuelle du manga

            // Gère l'upload de la nouvelle image de couverture
            $newCoverImage = $this->handleFileUpload($_FILES['cover_image'] ?? []);

            // Utilise la nouvelle image si elle a été uploadée et est valide (n'est pas 'placeholder.png' après handleFileUpload),
            // sinon conserve l'ancienne image.
            $coverImageToSave = ($newCoverImage !== 'placeholder.png') ? $newCoverImage : $currentCoverImage;

            // Si une nouvelle image a été uploadée avec succès et qu'il existait une ancienne image (non placeholder),
            // alors supprime l'ancienne image physique pour éviter l'accumulation.
            // S'assure que l'ancienne image n'est pas la placeholder avant de tenter de la supprimer.
            if (($newCoverImage !== 'placeholder.png') && ($currentCoverImage !== 'placeholder.png') && file_exists(self::UPLOAD_DIR . $currentCoverImage)) {
                unlink(self::UPLOAD_DIR . $currentCoverImage);
            }

            // Crée un objet Manga avec les données mises à jour et l'ID existant
            $updatedManga = new Manga(
                $title,
                $author,
                $volume,
                $description,
                $coverImageToSave,
                $publisher
            );
            $updatedManga->setId($id);

            // Met à jour le manga via le modèle
            if ($this->mangaModel->update($updatedManga)) {
                // Redirige vers la fiche du manga mis à jour
                header('Location: /mangatheque/mangas/' . $id);
                exit();
            } else {
                // Si la mise à jour échoue, redirige vers la liste ou affiche un message d'erreur
                header('Location: /mangatheque/mangas');
                exit();
            }
        }
        // Si la méthode n'est pas POST, redirige vers la page d'édition
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
}
