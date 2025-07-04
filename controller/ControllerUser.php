<?php
session_start(); // Assurez-vous que session_start() est bien appelé au début de chaque script qui utilise les sessions

class ControllerUser
{
    public function oneUserById(int $id)
    {
        $modelUser = new ModelUser();
        $user = $modelUser->getOneUserById($id);

        if ($user == null) {
            http_response_code(404);
            require './view/404.php';
            exit;
        }
        require './view/user/one-user.php';
    }

    public function deleteUserById(int $id)
    {
        $modelUser = new ModelUser();
        $succes = $modelUser->deleteOneUserById($id);

        if ($succes) {
            $_SESSION['message_success'] = "User supprimé.";
        } else {
            $_SESSION['message_error'] = "Aucun user supprimé.";
            http_response_code(404); // Le code 404 est maintenu comme dans votre code original
        }
        header('Location: /mangatheque/');
        exit;
    }

    // Méthode pour afficher le formulaire de mise à jour d'un utilisateur
    public function updateUserForm(int $id)
    {
        $modelUser = new ModelUser();
        $user = $modelUser->getOneUserById($id); // Récupère les infos du user

        if ($user === null) {
            http_response_code(404);
            require './view/404.php';
            exit;
        }

        // Envoie les infos du user dans la vue
        require './view/user/update-user-form.php'; // Le formulaire sera dans cette vue
    }

    // Méthode pour traiter la soumission du formulaire de mise à jour
    public function updateUser(int $id)
    {
        // Si la requête est de type GET, on affiche le formulaire de mise à jour
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $modelUser = new ModelUser();
            $user = $modelUser->getOneUserById($id);

            if ($user === null) {
                $_SESSION['message_error'] = "Utilisateur non trouvé.";
                header('Location: /mangatheque/');
                exit;
            }
            require './view/user/update-user-form.php'; // Renommé à 'update-user-form.php' pour cohérence
            exit; // Ajout d'un exit pour s'assurer que le script s'arrête ici si c'est un GET
        }

        // Si la requête est de type POST, on traite la mise à jour
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelUser = new ModelUser();
            $pseudo = trim($_POST['pseudo']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']); // Attention : le mot de passe n'est pas haché ici

            $req = $modelUser->updateOneUserById($id, $pseudo, $email, $password);

            if ($req) {
                $_SESSION['message_success'] = "User mis à jour."; // Correction de la variable $message à $_SESSION
                header('Location: /mangatheque/user/' . $id);
                exit;
            } else {
                $_SESSION['message_error'] = "Aucun user mis à jour.";
                // Redirection après échec de la mise à jour
                header('Location: /mangatheque/user/' . $id . '/edit'); // Redirige vers le formulaire d'édition
                exit;
            }
        }

        // Si la méthode n'est ni GET ni POST (par exemple PUT, DELETE, etc.)
        http_response_code(405); // Method Not Allowed
        $_SESSION['message_error'] = "Méthode non autorisée.";
        header('Location: /mangatheque/');
        exit;
    }
}