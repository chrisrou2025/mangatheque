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
        if($user == null) {
            // Retour d'une erreur 404 si l'utilisateur n'existe pas
            http_response_code(404);
            require './view/404.php';
            exit;
        }
        require './view/user/one-user.php';
    }
}
