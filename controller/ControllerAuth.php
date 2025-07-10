<?php

class ControllerAuth
{
    public function register()
    {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification des champs vides
            if (empty($_POST['pseudo']) || empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Tous les champs doivent être remplis !";
                header('Location: /mangatheque/register');
                exit;
            }

            // Nettoyage et validation des entrées
            $pseudo = trim($_POST['pseudo']);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            // Validation basique de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                header('Location: /mangatheque/register');
                exit;
            }

            // Hachage du mot de passe pour la sécurité
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Inclusion du modèle utilisateur si ce n'est pas déjà fait
            // require_once __DIR__ . '/../model/ModelUser.php'; // Décommentez si nécessaire

            $modelUser = new ModelUser();
            
            // Correction ici : suppression du double $modelUser->
            $successUser = $modelUser->createUser($pseudo, $email, $hashedPassword);

            if ($successUser) {
                $_SESSION['success'] = "Vous êtes bien enregistré ! Vous pouvez vous connecter !";
                header('Location: /mangatheque/login');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'insertion. Le pseudo ou l'email est peut-être déjà utilisé."; // Message plus spécifique
                header('Location: /mangatheque/register');
                exit;
            }
        }

        // Affichage de la vue d'enregistrement
        require __DIR__ . '/../view/auth/register.php';
    }
}