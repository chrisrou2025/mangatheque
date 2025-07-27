<?php

/**
 * Classe Model - Classe de base pour les modèles, gère la connexion à la base de données
 */
abstract class Model
{
    private static $db;

    private static function setDb()
    {
        try {
            // Assurez-vous que les informations de connexion sont correctes pour votre environnement
            self::$db = new PDO('mysql:host=localhost;dbname=mangatheque', 'root', 'root');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ajoute la gestion des erreurs
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            // En production, vous devriez logger l'erreur au lieu de l'afficher directement
            exit(); // Arrête l'exécution si la connexion échoue
        }
    }

    protected function getDb()
    {
        if (self::$db == null) {
            self::setDb();
        }

        return self::$db;
    }
}
