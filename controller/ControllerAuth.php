<?php

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

            // Vérifier si l'email existe déjà
            if ($modelUser->getUserByEmail($email)) {
                $_SESSION['error'] = "Cet email est déjà utilisé !";
                header('Location: /mangatheque/register');
                exit;
            }

            // Vérifier si le pseudo existe déjà
            if ($modelUser->getUserByPseudo($pseudo)) {
                $_SESSION['error'] = "Ce pseudo est déjà utilisé !";
                header('Location: /mangatheque/register');
                exit;
            }

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
     * Traite l'authentification et redirige l'utilisateur
     */
    public function login()
    {

        // Si c'est une requête POST, traiter l'authentification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validation : vérifier que les champs email et mot de passe sont remplis
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = 'Tous les champs doivent être remplis !';
                require __DIR__ . '/../view/auth/login.php';
                exit;
            }

            // Nettoyage des données reçues
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            // Validation du format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Format d'email invalide !";
                require __DIR__ . '/../view/auth/login.php';
                exit;
            }

            // Création d'une instance du modèle utilisateur
            $modelUser = new ModelUser();

            // Tentative de récupération de l'utilisateur par email
            $userSuccess = $modelUser->getUserByEmail($email);

            // Vérification de l'existence de l'utilisateur ET du mot de passe
            if ($userSuccess && password_verify($password, $userSuccess->getPassword())) {
                // Authentification réussie, on stocke les informations dans la session
                $_SESSION['success'] = 'Connecté avec succès !';
                $_SESSION['id'] = $userSuccess->getId();
                $_SESSION['pseudo'] = $userSuccess->getPseudo();

                // Redirection vers la page d'accueil
                header('Location: /mangatheque/');
                exit;
            } else {
                // Échec de l'authentification
                $_SESSION['error'] = 'Identifiants incorrects !';
                require __DIR__ . '/../view/auth/login.php';
                exit;
            }
        }

        // Si ce n'est pas une requête POST, afficher le formulaire de connexion
        require __DIR__ . '/../view/auth/login.php';
    }

    /**
     * Méthode pour gérer la déconnexion
     * Détruit la session et redirige l'utilisateur
     */
    public function logout()
    {
        // Détruire toutes les données de session
        session_unset();
        session_destroy();

        // Redémarrer une nouvelle session pour afficher le message de succès
        session_start();
        $_SESSION['success'] = 'Vous avez été déconnecté avec succès !';

        // Redirection vers la page d'accueil
        header('Location: /mangatheque/login');
        exit;
    }
}
