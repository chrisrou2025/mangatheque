<?php

class User
{
    private int $id;
    private string $pseudo;
    private string $password;
    private string $email;
    private DateTimeImmutable $created_at;

    public function __construct(array $datas)
    {
        $this->created_at = new \DateTimeImmutable();
        $this->hydrate($datas);
    }

    private function hydrate(array $datas)
    {
        foreach ($datas as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

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

    // Correction : méthode avec underscore comme vous le souhaitez
    public function getCreated_at(): DateTimeImmutable
    {
        return $this->created_at;
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

    // Méthode setter correspondante avec underscore
    public function setCreated_at(string $created_at): void
    {
        $this->created_at = new \DateTimeImmutable($created_at);
    }
}