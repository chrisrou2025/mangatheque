<?php

class ModelUser extends Model {
    
    /**
     * Récupère tous les utilisateurs depuis la base de données.
     * @return User[] Tableau de tous les objets User.
     */
    public function getUsers(): array {
        $query = $this->getDb()->query('SELECT id, pseudo, email, password FROM user');
        $arrayUser = [];

        while($user = $query->fetch(PDO::FETCH_ASSOC)){
            $arrayUser[] = new User($user);
        }

        return $arrayUser;
    }

    /**
     * Récupère un utilisateur par son ID depuis la base de données.
     * @param int $id L'identifiant de l'utilisateur.
     * @return User|null L'objet User si trouvé, sinon null.
     */
    public function getOneUserById(int $id): ?User {
        $req = $this->getDb()->prepare('SELECT id, pseudo, email, password, created_at FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user) : null;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe en clair (sera hashé).
     * @return bool Vrai si la création a réussi, faux sinon.
     */
    public function createUser(string $pseudo, string $email, string $password): bool {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->getDb()->prepare('INSERT INTO `user`(`pseudo`, `email`, `password`, `created_at`) VALUES (:pseudo, :email, :password, NOW())');
        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', $passwordHash, PDO::PARAM_STR);

        return $req->execute();
    }

    /**
     * Met à jour un utilisateur existant dans la base de données.
     * @param int $id L'identifiant de l'utilisateur.
     * @param string $pseudo Le nouveau pseudo.
     * @param string $email Le nouvel email.
     * @param string $password Le nouveau mot de passe (sera hashé).
     * @return bool Vrai si la mise à jour a réussi, faux sinon.
     */
    public function updateOneUserById(int $id, string $pseudo, string $email, string $password): bool {
        // Hash du nouveau mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $req = $this->getDb()->prepare('UPDATE user SET pseudo = :pseudo, email = :email, password = :password WHERE id = :id');
        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $req->bindParam(':id', $id, PDO::PARAM_INT);

        return $req->execute();
    }

    /**
     * Supprime un utilisateur de la base de données par son ID.
     * @param int $id L'identifiant de l'utilisateur à supprimer.
     * @return bool Vrai si la suppression a réussi, faux sinon.
     */
    public function deleteOneUserById(int $id): bool {
        $req = $this->getDb()->prepare('DELETE FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        return $req->rowCount() > 0;
    }

    /**
     * Récupère un utilisateur par son email depuis la base de données.
     * @param string $email L'email de l'utilisateur.
     * @return User|null L'objet User si trouvé, sinon null.
     */
    public function getUserByEmail(string $email): ?User {
        $req = $this->getDb()->prepare('SELECT id, pseudo, email, password, created_at FROM user WHERE email = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user) : null;
    }
}