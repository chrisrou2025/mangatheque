<?php

/**
 * Classe Manga - Représente un manga avec toutes ses propriétés
 */

class Manga
{
    // Propriétés privées de la classe
    private ?int $id;                // ID unique du manga (null pour un nouveau manga)
    private string $title;           // Titre du manga
    private string $author;          // Auteur du manga
    private int $volume;             // Numéro de volume
    private ?string $description;    // Description du manga (peut être null)
    private string $coverImage;      // Nom du fichier image de couverture
    private ?string $publisher;      // Maison d'édition (peut être null)
    private string $type;            // Type de manga (Shonen, Seinen, etc.)
    private ?float $averageRating;   // Note moyenne du manga (peut être null)

    /**
     * Constructeur de la classe Manga
     * IMPORTANT : L'ordre des paramètres doit correspondre à l'utilisation dans le contrôleur
     */
    public function __construct(
        string $title,                              // 1er paramètre : titre (obligatoire)
        string $author,                             // 2ème paramètre : auteur (obligatoire)
        int $volume,                                // 3ème paramètre : volume (obligatoire)
        ?string $description = null,                // 4ème paramètre : description (optionnel)
        string $coverImage = 'placeholder.png',    // 5ème paramètre : image (optionnel, valeur par défaut)
        ?string $publisher = null,                  // 6ème paramètre : éditeur (optionnel)
        string $type = 'Shonen'                     // 7ème paramètre : type (optionnel, valeur par défaut)
    ) {
        $this->title = $title;
        $this->author = $author;
        $this->volume = $volume;
        $this->description = $description;
        $this->coverImage = $coverImage;
        $this->publisher = $publisher;
        $this->type = $type;                        // IMPORTANT : assignation du type
        $this->id = null;                           // ID null pour un nouveau manga
        $this->averageRating = null;                // Note moyenne initialement null
    }

    // ========== GETTERS (méthodes pour récupérer les valeurs) ==========

    /**
     * Récupère l'ID du manga
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le titre du manga
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Récupère l'auteur du manga
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Récupère le numéro de volume
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    /**
     * Récupère la description du manga
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Récupère le nom du fichier image de couverture
     */
    public function getCoverImage(): string
    {
        return $this->coverImage;
    }

    /**
     * Récupère la maison d'édition
     */
    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * Récupère le type de manga - IMPORTANT pour l'affichage
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Récupère la note moyenne du manga
     */
    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    // ========== SETTERS (méthodes pour modifier les valeurs) ==========

    /**
     * Définit l'ID du manga (utilisé après insertion en base)
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this; // Retourne l'objet pour permettre le chaînage de méthodes
    }

    /**
     * Définit le titre du manga
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Définit l'auteur du manga
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Définit le numéro de volume
     */
    public function setVolume(int $volume): self
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * Définit la description du manga
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Définit l'image de couverture
     */
    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;
        return $this;
    }

    /**
     * Définit la maison d'édition
     */
    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * Définit le type de manga - IMPORTANT pour la mise à jour
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Définit la note moyenne du manga
     */
    public function setAverageRating(?float $averageRating): self
    {
        $this->averageRating = $averageRating;
        return $this;
    }

    // ========== MÉTHODES UTILITAIRES ==========

    /**
     * Retourne une représentation textuelle du manga (utile pour le débogage)
     */
    public function __toString(): string
    {
        return "Manga: {$this->title} (Vol. {$this->volume}) par {$this->author} - Type: {$this->type}";
    }

    /**
     * Vérifie si le manga a une image de couverture personnalisée
     */
    public function hasCustomCover(): bool
    {
        return $this->coverImage !== 'placeholder.png';
    }

    /**
     * Vérifie si le manga a une note moyenne
     */
    public function hasRating(): bool
    {
        return $this->averageRating !== null;
    }
}