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
            http_response_code(404);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pseudo'], $_POST['email'])) {
            $modelUser = new ModelUser();
            $user = $modelUser->getOneUserById($id);

            if ($user === null) {
                $_SESSION['message_error'] = "Utilisateur non trouvé.";
                header('Location: /mangatheque/');
                exit;
            }

            $pseudo = htmlspecialchars(trim($_POST['pseudo']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'] ?? '';

            $userData = [
                'id' => $id,
                'pseudo' => $pseudo,
                'email' => $email
            ];

            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userData['password'] = $hashedPassword;
            } else {
                $userData['password'] = $user->getPassword();
            }

            $success = $modelUser->updateUser($userData);

            if ($success) {
                $_SESSION['message_success'] = "Utilisateur mis à jour avec succès.";
            } else {
                $_SESSION['message_error'] = "Échec de la mise à jour de l'utilisateur.";
            }
        } else {
            $_SESSION['message_error'] = "Données du formulaire invalides.";
        }

        header('Location: /mangatheque/user/' . $id);
        exit;
    }
}