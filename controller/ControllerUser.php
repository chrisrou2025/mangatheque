<?php

class ControllerUser
{
    public function oneUserById(int $id)
    {
        // Instanciation du modèle utilisateur
        $modelUser = new ModelUser();

        // Récupération de l'utilisateur par son ID
        $user = $modelUser->getOneUserById($id);

        // Vérification si l'utilisateur existe
        if ($user == null) {
            // Retour d'une erreur 404 si l'utilisateur n'existe pas
            http_response_code(404);
            require './view/404.php';
            exit;
        }
        require './view/user/one-user.php';
    }

    public function updateUser(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $modelUser = new ModelUser();
            $user = $modelUser->getOneUserById($id);

            if ($user === null) {
                $error = "Aucun user trouvé";
                header('location: /mangatheque/');
                exit;
            }

            require './view/user/update-form.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelUser = new ModelUser();
            $pseudo = trim($_POST['pseudo']);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);
            $req = $modelUser->updateOneUserById($id, $pseudo, $email, $password);
        }

        http_response_code(405);
        header('Location: /mangatheque/');
        exit;
    }

    public function deleteUserById(int $id)
    {
        $modelUser = new ModelUser();

        // Tentative de suppression de l'utilisateur
        $success = $modelUser->deleteOneUserById($id);


        if ($success) {
            $message = 'User supprimé. ';
        } else {
            $error = 'Aucun user supprimé';
            http_response_code(404);
        }
        header('Location: /mangatheque/users');
        exit;
    }
}
