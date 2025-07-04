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
    public function updateUser(array $data): bool
    {
        $db = $this->getDb();

        $sql = 'UPDATE user SET pseudo = :pseudo, email = :email';
        if (isset($data['password']) && !empty($data['password'])) { // Vérifie si le mot de passe est fourni et non vide
            $sql .= ', password = :password';
        }
        $sql .= ' WHERE id = :id';

        $req = $db->prepare($sql);

        $req->bindParam(':pseudo', $data['pseudo'], PDO::PARAM_STR);
        $req->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $req->bindParam(':id', $data['id'], PDO::PARAM_INT);

        if (isset($data['password']) && !empty($data['password'])) {
            $req->bindParam(':password', $data['password'], PDO::PARAM_STR);
        }

        return $req->execute();
    }
}