<?php

/**
 * Classe Review - Représente un avis sur un manga
 */

class Review
{
    private ?int $id;
    private int $mangaId;
    private int $userId;
    private int $rating;
    private ?string $comment;
    private ?string $createdAt;
    private ?string $pseudo;

    public function __construct(int $mangaId, int $userId, int $rating, ?string $comment = null)
    {
        $this->mangaId = $mangaId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->id = null;
        $this->createdAt = null;
        $this->pseudo = null;
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
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

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }
}
