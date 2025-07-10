<?php
class ModelUser extends Model {
    public function getUsers() : array {
        $query = $this->getDb()->query('SELECT id, pseudo, email, password FROM user');
        $arrayUser = [];

        while($user = $query->fetch(PDO::FETCH_ASSOC)){
            $arrayUser[] = new User($user);
        }

        return $arrayUser;
    }

    public function getOneUserById(int $id) : ?User {
        $req = $this->getDb()->prepare('SELECT id, pseudo, email, password, created_at FROM user WHERE id = :id ');
        $req->bindParam(':id', $id, PDO::PARAM_INT);

        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user) : null;
    }

    public function createUser(string $pseudo, string $email, string $password) : bool {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->getDb()->prepare('INSERT INTO `user`(`pseudo`, `email`, `password`, `created_at`) VALUES (:pseudo, :email, :password, NOW())');
        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', $passwordHash, PDO::PARAM_STR);

        return $req->execute();
    }

    public function updateOneUserById(int $id, string $pseudo, string $email, string $password) : bool {
        $req = $this->getDb()->prepare('UPDATE user set pseudo = :pseudo, email = :email, password = :password WHERE id= :id');
        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', $password, PDO::PARAM_STR);
        $req->bindParam(':id', $id, PDO::PARAM_INT);

        return $req->execute();
    }

    public function deleteOneUserById(int $id) : bool {
        $req = $this->getDb()->prepare('DELETE FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        return $req->rowCount() > 0;
    }

    public function getUserByEmail(string $email): ?User
    {
        $req = $this->getDb()->prepare('SELECT id, pseudo, email, password, created_at FROM user WHERE email = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user) : null;
    }
}