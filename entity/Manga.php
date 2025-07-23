<?php

/**
 * Classe représentant un manga avec toutes ses propriétés
 */
class Manga
{
    private ?int $id;
    private string $title;
    private string $author;
    private int $volume;
    private string $description;
    private string $coverImage;
    private string $publisher;
    private string $type; // Nouveau champ pour le type de manga

    /**
     * Constructeur de la classe Manga
     * @param string $title Titre du manga
     * @param string $author Auteur du manga
     * @param int $volume Numéro de volume
     * @param string $description Description du manga
     * @param string $coverImage Nom du fichier de couverture
     * @param string $publisher Maison d'édition
     * @param string $type Type de manga (Shonen, Kodomo, Shôjo, Seinen, Josei)
     */
    public function __construct(string $title, string $author, int $volume, string $description, string $coverImage = 'placeholder.png', string $publisher = '', string $type = 'Shonen')
    {
        $this->title = $title;
        $this->author = $author;
        $this->volume = $volume;
        $this->description = $description;
        $this->coverImage = $coverImage;
        $this->publisher = $publisher;
        $this->type = $type;
        $this->id = null;
    }

    // Getters
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

    // Setters
    public function setId(int $id): void
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

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}