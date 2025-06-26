<?php

class User
{
    private int $id;
    private string $pseudo;
    private string $password;
    private string $email;
    private DateTimeImmutable $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

// Création et initialisation du premier utilisateur
$user = new User();
$user->setId(1);
$user->setPseudo('Alice');
$user->setPassword('motdepasse123');
$user->setEmail('alice@example.com');
$user->setCreatedAt(new DateTimeImmutable());

// Création et initialisation du deuxième utilisateur
$user2 = new User();
$user2->setId(2);
$user2->setPseudo('Bob');
$user2->setPassword('autre_motdepasse');
$user2->setEmail('bob@example.com');
$user2->setCreatedAt(new DateTimeImmutable());

echo $user->getId() . '<br>'; // Ajout d'un saut de ligne HTML pour une meilleure lisibilité
echo $user2->getId() . '<br>'; // Ajout d'un saut de ligne HTML

?>