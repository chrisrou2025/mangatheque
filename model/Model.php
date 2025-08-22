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
            // Connexion à la base de données avec PDO
            self::$db = new PDO('mysql:host=localhost;dbname=mangatheque', 'root', 'root');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ajoute la gestion des erreurs
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, on affiche un message et on arrête l'exécution
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            // Optionnel : log l'erreur pour le débogage
            error_log($e->getMessage()); // Log l'erreur
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
