<?php

// Définition de la classe MangaModel qui hérite de Model
class MangaModel extends Model
{

    // Récupère tous les mangas depuis la base de données.  

    public function getAll(): array
    {
        $mangas = []; // Initialise un tableau vide pour stocker les objets Manga
        // Utilise $this->getDb() héritée de la classe Model
        // MODIFIÉ : Ajout de la jointure avec la table reviews pour récupérer la note moyenne
        $stmt = $this->getDb()->query("
            SELECT 
                m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type,
                AVG(r.rating) as average_rating
            FROM mangas m
            LEFT JOIN reviews r ON m.id = r.manga_id
            GROUP BY m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type
            ORDER BY m.id DESC
        ");
        // Exécute la requête et récupère tous les résultats
        $data = $stmt->fetchAll();

        // Parcourt les données récupérées et crée des objets Manga
        foreach ($data as $row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher'], $row['type']);
            $manga->setId($row['id']); // Assigne l'ID récupéré de la base de données
            // AJOUTÉ : Assigne la note moyenne à l'objet Manga
            $manga->setAverageRating($row['average_rating'] ? (float)$row['average_rating'] : null);
            $mangas[] = $manga; // Ajoute l'objet Manga au tableau
        }
        return $mangas;
    }


    //  Récupère un manga par son ID depuis la base de données.

    public function getById(int $id): ?Manga
    {
        // Utilise $this->getDb() héritée de la classe Model
        // MODIFIÉ : Ajout de la jointure avec la table reviews pour récupérer la note moyenne
        $stmt = $this->getDb()->prepare("
            SELECT 
                m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type,
                AVG(r.rating) as average_rating
            FROM mangas m
            LEFT JOIN reviews r ON m.id = r.manga_id
            WHERE m.id = :id
            GROUP BY m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type
        ");
        // Lie la valeur de l'ID au placeholder en utilisant bindValue pour éviter les notices
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécute la requête
        $stmt->execute();
        // Récupère la première ligne de résultat
        $row = $stmt->fetch();

        // Si une ligne est trouvée, crée et retourne un objet Manga
        if ($row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher'], $row['type']);
            $manga->setId($row['id']);
            // AJOUTÉ : Assigne la note moyenne à l'objet Manga
            $manga->setAverageRating($row['average_rating'] ? (float)$row['average_rating'] : null);
            return $manga;
        }
        return null; // Retourne null si aucun manga n'est trouvé
    }


    // Ajoute un nouveau manga à la base de données.

    public function add(Manga $manga): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("INSERT INTO mangas (title, author, volume, description, cover_image, publisher, type) VALUES (:title, :author, :volume, :description, :cover_image, :publisher, :type)");

        // Stocke les valeurs des propriétés dans des variables locales pour éviter les notices avec bindParam
        $title = $manga->getTitle();
        $author = $manga->getAuthor();
        $volume = $manga->getVolume();
        $description = $manga->getDescription();
        $coverImage = $manga->getCoverImage();
        $publisher = $manga->getPublisher();
        $type = $manga->getType();

        // Lie les valeurs des propriétés du manga aux placeholders
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':volume', $volume, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cover_image', $coverImage);
        $stmt->bindParam(':publisher', $publisher);
        $stmt->bindParam(':type', $type);

        // Exécute la requête
        $result = $stmt->execute();
        // Si l'insertion a réussi, met à jour l'ID de l'objet Manga avec le dernier ID inséré
        if ($result) {
            $manga->setId((int)$this->getDb()->lastInsertId());
        }
        return $result;
    }


    //  Met à jour un manga existant dans la base de données.

    public function update(Manga $manga): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("UPDATE mangas SET title = :title, author = :author, volume = :volume, description = :description, cover_image = :cover_image, publisher = :publisher, type = :type WHERE id = :id");

        // Stocke les valeurs des propriétés dans des variables locales pour éviter les notices avec bindParam
        $title = $manga->getTitle();
        $author = $manga->getAuthor();
        $volume = $manga->getVolume();
        $description = $manga->getDescription();
        $coverImage = $manga->getCoverImage();
        $publisher = $manga->getPublisher();
        $type = $manga->getType();
        $id = $manga->getId(); // L'ID pour la clause WHERE

        // Lie les valeurs des propriétés du manga aux placeholders
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':volume', $volume, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cover_image', $coverImage);
        $stmt->bindParam(':publisher', $publisher);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécute la requête et retourne le résultat
        return $stmt->execute();
    }


    //   Supprime un manga de la base de données par son ID.

    public function delete(int $id): bool
    {
        // Utilise $this->getDb() héritée de la classe Model
        $stmt = $this->getDb()->prepare("DELETE FROM mangas WHERE id = :id");
        // Lie la valeur de l'ID au placeholder en utilisant bindValue pour éviter les notices
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécute la requête et retourne le résultat
        return $stmt->execute();
    }

    /**
     * Ajoute un manga aux favoris d'un utilisateur
     */
    public function addFavorite(int $userId, int $mangaId): bool
    {
        try {
            $stmt = $this->getDb()->prepare("INSERT INTO favorites (user_id, manga_id) VALUES (:user_id, :manga_id)");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Si l'erreur est due à une contrainte d'unicité (favori déjà existant)
            if ($e->getCode() == 23000) {
                return false; // Favori déjà existant
            }
            throw $e; // Re-lance l'exception pour les autres erreurs
        }
    }

    /**
     * Retire un manga des favoris d'un utilisateur
     */
    public function removeFavorite(int $userId, int $mangaId): bool
    {
        $stmt = $this->getDb()->prepare("DELETE FROM favorites WHERE user_id = :user_id AND manga_id = :manga_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Vérifie si un manga est dans les favoris d'un utilisateur
     */
    public function isFavorite(int $userId, int $mangaId): bool
    {
        $stmt = $this->getDb()->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = :user_id AND manga_id = :manga_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère les mangas favoris d'un utilisateur
     */
    public function getUserFavorites(int $userId): array
    {
        $mangas = [];
        $stmt = $this->getDb()->prepare("
        SELECT m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type, mf.created_at as favorite_date
        FROM mangas m
        INNER JOIN favorites mf ON m.id = mf.manga_id
        WHERE mf.user_id = :user_id
        ORDER BY mf.created_at DESC
    ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll();

        foreach ($data as $row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher'], $row['type']);
            $manga->setId($row['id']);
            $mangas[] = $manga;
        }

        return $mangas;
    }

    /**
     * Récupère le top des mangas les plus ajoutés aux favoris
     */
    public function getTopFavorites(int $limit = 5): array
    {
        $results = [];
        $stmt = $this->getDb()->prepare("
        SELECT 
            m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type,
            COUNT(mf.manga_id) as favorite_count
        FROM mangas m
        LEFT JOIN favorites mf ON m.id = mf.manga_id
        GROUP BY m.id, m.title, m.author, m.volume, m.description, m.cover_image, m.publisher, m.type
        HAVING favorite_count > 0
        ORDER BY favorite_count DESC, m.title ASC
        LIMIT :limit
    ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll();

        foreach ($data as $row) {
            $manga = new Manga($row['title'], $row['author'], $row['volume'], $row['description'], $row['cover_image'], $row['publisher'], $row['type']);
            $manga->setId($row['id']);

            $results[] = [
                'manga' => $manga,
                'favorite_count' => (int)$row['favorite_count']
            ];
        }

        return $results;
    }

    /**
     * Compte le nombre total de favoris pour un manga donné
     */
    public function getFavoriteCount(int $mangaId): int
    {
        $stmt = $this->getDb()->prepare("SELECT COUNT(*) FROM favorites WHERE manga_id = :manga_id");
        $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /**
     * Ajoute un avis (note et commentaire) pour un manga.
     */
    public function addReview(int $mangaId, int $userId, int $rating, ?string $comment): bool
    {
        try {
            $stmt = $this->getDb()->prepare("INSERT INTO reviews (manga_id, user_id, rating, comment) VALUES (:manga_id, :user_id, :rating, :comment)");
            $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Gérer le cas où l'utilisateur a déjà laissé un avis pour ce manga
            if ($e->getCode() == 23000) { // Code d'erreur pour violation de contrainte unique
                // Vous pouvez logguer l'erreur ou la gérer silencieusement
                return false;
            }
            throw $e; // Re-lancer l'exception pour les autres erreurs inattendues
        }
    }

/**
 * Récupère tous les avis pour un manga donné.
 * Jointure avec la table user pour récupérer le nom d'utilisateur.
 */
public function getReviewsByMangaId(int $mangaId): array
{
    $reviews = [];
    
    try {
        $stmt = $this->getDb()->prepare("
            SELECT 
                r.id, r.rating, r.comment, r.created_at,
                u.pseudo
            FROM reviews r
            INNER JOIN user u ON r.user_id = u.id
            WHERE r.manga_id = :manga_id
            ORDER BY r.created_at DESC
        ");
        $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            // Créer un objet Review complet au lieu de stdClass
            $review = new Review($mangaId, 0, (int)$row['rating'], $row['comment']);
            $review->setId((int)$row['id']);
            $review->setCreatedAt($row['created_at']);
            $review->setPseudo($row['pseudo']);

            $reviews[] = $review;
        }
        
    } catch (PDOException $e) {
        // Logger l'erreur au lieu de la laisser planter
        error_log("Erreur lors de la récupération des avis: " . $e->getMessage());
        // Retourner un tableau vide en cas d'erreur
        return [];
    }

    return $reviews;
}

    /**
     * Calcule et retourne la note moyenne d'un manga.
     * Retourne null si aucune note n'est présente.
     */
    public function getAverageRatingForManga(int $mangaId): ?float
    {
        $stmt = $this->getDb()->prepare("SELECT AVG(rating) FROM reviews WHERE manga_id = :manga_id");
        $stmt->bindValue(':manga_id', $mangaId, PDO::PARAM_INT);
        $stmt->execute();
        $average = $stmt->fetchColumn();
        return $average !== null ? (float)$average : null;
    }
}