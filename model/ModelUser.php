<?php
class ModelUser extends Model
{
    public function getUsers(): array
    {
        $query = $this->getDb()->query('SELECT id, pseudo, email, password FROM user');

        $arrayUser = [];
        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            // $created_at = new DateTimeImmutable($user['created_at']);
            $arrayUser[] = new User($user);
        }

        return $arrayUser;
    }

    public function getOneUserById(int $id): ?User
    {
        $db = $this->getDb();

        $req = $db->prepare('SELECT id, pseudo, email, password FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);
        // Correction de la syntaxe du return avec l'opérateur ternaire
        return $user ? new User($user) : null;
    }
}
