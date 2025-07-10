<?php
session_start();
/**
 * Contrôleur d'authentification
 * Gère l'inscription et la connexion des utilisateurs
 */
class ControllerAuth
{
    /**
     * Méthode pour gérer l'inscription d'un nouvel utilisateur
     */
    public function register()
    {
        // Vérification si la requête est de type POST (formulaire soumis)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validation : vérifier que tous les champs obligatoires sont remplis
            if (empty($_POST['pseudo']) || empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Tous les champs doivent être remplis !";
                header('Location: /mangatheque/register');
                exit;
            }

            // Nettoyage des données reçues
            $pseudo = trim($_POST['pseudo']);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            // Validation supplémentaire : vérifier le format de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Format d'email invalide !";
                header('Location: /mangatheque/register');
                exit;
            }

            // Création d'une instance du modèle utilisateur
            $modelUser = new ModelUser();

            // Tentative de création du nouvel utilisateur
            $successUser = $modelUser->createUser($pseudo, $email, $password);

            // Vérification du succès de l'insertion
            if ($successUser) {
                $_SESSION['success'] = "Vous êtes bien enregistré ! Vous pouvez vous connecter !";
                header('Location: /mangatheque/login');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription.";
                header('Location: /mangatheque/register');
                exit;
            }
        }

        // Si ce n'est pas une requête POST, afficher le formulaire d'inscription
        require __DIR__ . '/../view/auth/register.php';
    }

    /**
     * Méthode pour gérer la connexion
     * Affiche seulement le formulaire de connexion pour l'instant
     */
    public function login()
    {
        // Pour l'instant, on affiche seulement le formulaire de connexion
        // La logique de connexion sera implémentée plus tard
        require __DIR__ . '/../view/auth/login.php';
    }
}
