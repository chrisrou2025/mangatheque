<?php

// Définition de la classe Manga
class Manga
{
    // Propriétés privées de la classe Manga
    private ?int $id = null; // Identifiant unique du manga, nullable car il peut ne pas exister lors de la création
    private string $title; // Titre du manga
    private string $author; // Auteur du manga
    private int $volume; // Numéro de volume
    private string $description; // Description du manga
    private string $coverImage; // Chemin de l'image de couverture du manga
    private string $publisher; // Nom de la maison d'édition

    // Constructeur de la classe Manga
    public function __construct(string $title = '', string $author = '', int $volume = 0, string $description = '', string $coverImage = 'placeholder.png', string $publisher = '')
    {
        $this->title = $title;
        $this->author = $author;
        $this->volume = $volume;
        $this->description = $description;
        $this->coverImage = $coverImage; // Initialise avec une image par défaut
        $this->publisher = $publisher; // Initialise la maison d'édition
    }

    // Méthodes getter pour accéder aux propriétés
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

    // Méthodes setter pour modifier les propriétés
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setVolume(int $volume): void
    {
        $this->volume = $volume;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCoverImage(string $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }
}
