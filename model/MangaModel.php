<?php

// Inclusion de la classe Manga (entité)
// require_once 'entity/Manga.php';
// Inclusion de la classe Model pour l'héritage
// require_once 'Model.php';

// Définition de la classe MangaModel qui hérite de Model
class MangaModel extends Model
{
    // Plus besoin de propriété $db ni de constructeur
    // La connexion est gérée par la classe parent Model

    /**
     * Récupère tous les mangas depuis la base de données.
     * @return Manga[] Tableau de tous les objets Manga.
     */
    public function getAll(): array
    {
        $mangas = []; // Initialise un tableau vide pour stocker les objets Manga
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->query("SELECT id, title, author, volume, description, cover_image, publisher FROM mangas ORDER BY id DESC");
        // Exécute la requête et récupère tous les résultats
        $data = $stmt->fetchAll();

        // Parcourt les données récupérées et crée des objets Manga
        foreach ($data as $row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher']);
            $manga->setId($row['id']); // Assigne l'ID récupéré de la base de données
            $mangas[] = $manga; // Ajoute l'objet Manga au tableau
        }
        return $mangas;
    }

    /**
     * Récupère un manga par son ID depuis la base de données.
     * @param int $id L'identifiant du manga.
     * @return Manga|null L'objet Manga si trouvé, sinon null.
     */
    public function getById(int $id): ?Manga
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("SELECT id, title, author, volume, description, cover_image, publisher FROM mangas WHERE id = :id");
        // Lie la valeur de l'ID au placeholder en utilisant bindValue pour éviter les notices
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécute la requête
        $stmt->execute();
        // Récupère la première ligne de résultat
        $row = $stmt->fetch();

        // Si une ligne est trouvée, crée et retourne un objet Manga
        if ($row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher']);
            $manga->setId($row['id']);
            return $manga;
        }
        return null; // Retourne null si aucun manga n'est trouvé
    }

    /**
     * Ajoute un nouveau manga à la base de données.
     * @param Manga $manga L'objet Manga à ajouter.
     * @return bool Vrai si l'ajout a réussi, faux sinon.
     */
    public function add(Manga $manga): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("INSERT INTO mangas (title, author, volume, description, cover_image, publisher) VALUES (:title, :author, :volume, :description, :cover_image, :publisher)");

        // Stocke les valeurs des propriétés dans des variables locales pour éviter les notices avec bindParam
        $title = $manga->getTitle();
        $author = $manga->getAuthor();
        $volume = $manga->getVolume();
        $description = $manga->getDescription();
        $coverImage = $manga->getCoverImage();
        $publisher = $manga->getPublisher();

        // Lie les valeurs des propriétés du manga aux placeholders
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':volume', $volume, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cover_image', $coverImage);
        $stmt->bindParam(':publisher', $publisher);

        // Exécute la requête
        $result = $stmt->execute();
        // Si l'insertion a réussi, met à jour l'ID de l'objet Manga avec le dernier ID inséré
        if ($result) {
            $manga->setId((int)$this->getDb()->lastInsertId());
        }
        return $result;
    }

    /**
     * Met à jour un manga existant dans la base de données.
     * @param Manga $manga L'objet Manga mis à jour (doit avoir un ID).
     * @return bool Vrai si la mise à jour a réussi, faux sinon.
     */
    public function update(Manga $manga): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("UPDATE mangas SET title = :title, author = :author, volume = :volume, description = :description, cover_image = :cover_image, publisher = :publisher WHERE id = :id");

        // Stocke les valeurs des propriétés dans des variables locales pour éviter les notices avec bindParam
        $title = $manga->getTitle();
        $author = $manga->getAuthor();
        $volume = $manga->getVolume();
        $description = $manga->getDescription();
        $coverImage = $manga->getCoverImage();
        $publisher = $manga->getPublisher();
        $id = $manga->getId(); // L'ID pour la clause WHERE

        // Lie les valeurs des propriétés du manga aux placeholders
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':volume', $volume, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cover_image', $coverImage);
        $stmt->bindParam(':publisher', $publisher);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécute la requête et retourne le résultat
        return $stmt->execute();
    }

    /**
     * Supprime un manga de la base de données par son ID.
     * @param int $id L'identifiant du manga à supprimer.
     * @return bool Vrai si la suppression a réussi, faux sinon.
     */
    public function delete(int $id): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("DELETE FROM mangas WHERE id = :id");
        // Lie la valeur de l'ID au placeholder en utilisant bindValue pour éviter les notices
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête et retourne le résultat
        return $stmt->execute();
    }
}