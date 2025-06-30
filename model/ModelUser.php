<?php
class ModelUser
{
    public function getUsers(): array
    {
        $db = new PDO('mysql:host=localhost;dbname=mangatheque', 'root', 'root');
        $query = $db->query('SELECT id, pseudo, email, password FROM users');

        $arrayUser = [];
        while ($user = $query->fetch(PDO::FETCH_ASSOC));
        $arrayUser[] = new User($user['id'], $user['pseudo'], $user['email'], $user['password']);

        return $arrayUser;
    }
}
