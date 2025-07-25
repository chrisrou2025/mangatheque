<?php

// Dans votre fichier Manga.php (par exemple, app/Entity/Manga.php ou app/Model/Manga.php)

class Manga
{
    private ?int $id;
    private string $title;
    private string $author;
    private int $volume;
    private string $description;
    private string $coverImage;
    private string $publisher;
    private string $type;
    private ?float $averageRating; // Nouvelle propriété pour la note moyenne

    public function __construct(
        string $title,
        string $author,
        int $volume,
        string $description,
        string $coverImage,
        string $publisher,
        string $type = 'Manga' // Valeur par défaut si non spécifié
    ) {
        $this->title = $title;
        $this->author = $author;
        $this->volume = $volume;
        $this->description = $description;
        $this->coverImage = $coverImage;
        $this->publisher = $publisher;
        $this->type = $type;
        $this->id = null;
        $this->averageRating = null; // Initialisation
    }

    // Getters existants...
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function getVolume(): int
    {
        return $this->volume;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getCoverImage(): string
    {
        return $this->coverImage;
    }
    public function getPublisher(): string
    {
        return $this->publisher;
    }
    public function getType(): string
    {
        return $this->type;
    }

    // Nouveau getter pour la note moyenne
    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    // Setters existants...
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }
    public function setVolume(int $volume): self
    {
        $this->volume = $volume;
        return $this;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;
        return $this;
    }
    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;
        return $this;
    }
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    // Nouveau setter pour la note moyenne
    public function setAverageRating(?float $averageRating): self
    {
        $this->averageRating = $averageRating;
        return $this;
    }
}
