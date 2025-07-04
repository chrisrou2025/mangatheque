<?php
class ModelUser extends Model
{
    public function getUsers(): array
    {
        $query = $this->getDb()->query('SELECT id, pseudo, email, password FROM user');

        $arrayUser = [];
        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
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
        return $user ? new User($user) : null;
    }

    public function deleteOneUserById(int $id): bool
    {
        $db = $this->getDb();
        $req = $db->prepare('DELETE FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        return $req->execute() && $req->rowCount() > 0;
    }

    // Méthode pour mettre à jour un utilisateur dans la base de données
    // Le nom de la méthode devrait correspondre à celle appelée dans le contrôleur : updateOneUserById
    public function updateOneUserById(int $id, string $pseudo, string $email, string $password) : bool //
    {
        $req = $this->getDb()->prepare('UPDATE user SET pseudo = :pseudo, email = :email, password = :password WHERE id = :id'); //

        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR); //
        $req->bindParam(':email', $email, PDO::PARAM_STR); //
        $req->bindParam(':password', $password, PDO::PARAM_STR); // Ajout du bind pour le mot de passe
        $req->bindParam(':id', $id, PDO::PARAM_INT); //

        return $req->execute(); //
    }
}