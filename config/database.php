<?php
// Fichier de configuration pour la base de données

// Définir les constantes pour les informations de connexion à la base de données
define('DB_HOST', 'localhost'); // Hôte de la base de données (souvent 'localhost')
define('DB_NAME', 'mangatheque'); // Nom de votre base de données
define('DB_USER', 'root'); // Nom d'utilisateur de la base de données
define('DB_PASS', 'root'); // Mot de passe de la base de données (vide par défaut pour XAMPP/WAMP)

/**
 * Fonction pour obtenir une connexion PDO à la base de données.
 * @return PDO L'objet PDO connecté à la base de données.
 * @throws PDOException Si la connexion échoue.
 */
function getDbConnection(): PDO
{
    // Construire la chaîne DSN (Data Source Name)
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';

    // Options PDO pour la gestion des erreurs et le mode de récupération par défaut
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Mode d'erreur : lancer des exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mode de récupération par défaut : tableau associatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactiver l'émulation des requêtes préparées pour de meilleures performances et sécurité
    ];

    try {
        // Tenter de créer une nouvelle instance PDO
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // En cas d'échec de connexion, afficher un message d'erreur et arrêter l'exécution
        // En production, vous devriez logger l'erreur et afficher un message générique
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }
}
