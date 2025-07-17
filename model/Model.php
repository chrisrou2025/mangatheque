<?php
abstract class Model
{
    private static $db;

    private static function setDb()
    {
        try {
            self::$db = new PDO('mysql:host=localhost;dbname=mangatheque', 'root', 'root');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function getDb()
    {
        if (self::$db == null) {
            self::setDb();
        }

        return self::$db;
    }

    // Correction du bug : utilisation du bon nom de variable
    public function deleteOneUserById(int $id): bool
    {
        $req = $this->getDb()->prepare('DELETE FROM user WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute(); // Ajout de l'exécution de la requête

        return $req->rowCount() > 0;
    }
}
