<?php

// app/Entity/Review.php (ou app/Model/Review.php)

class Review
{
    private ?int $id;
    private int $mangaId;
    private int $userId;
    private int $rating;
    private ?string $comment;
    private ?string $createdAt;
    private ?string $username; // Pour stocker le nom d'utilisateur qui a laissé l'avis

    public function __construct(int $mangaId, int $userId, int $rating, ?string $comment = null)
    {
        $this->mangaId = $mangaId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->id = null;
        $this->createdAt = null;
        $this->username = null;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMangaId(): int
    {
        return $this->mangaId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    // Setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
}
