<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!empty($_POST['pseudo']) && !empty($_POST['pwd'])) {
        $pseudo = $_POST['pseudo'];
        $pwd = $_POST['pwd'];

        $bdd = new PDO('mysql:host=localhost;dbname=mangatheque', 'root', 'root');
        $req = $bdd->prepare("SELECT id, pseudo, password FROM users WHERE pseudo = $pseudo");
        $req->execute();

        if ($req->rowCount() == 1) {
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if($user['password'] == $pwd) {
                echo '<h1>Bonjour ' . ($user['pseudo']) . '</h1>';

                $error = '<p style="color: red;">Mot de passe incorrect</p>';
            }
            
        } else {
            $error = '<p style="color: red;">Pseudo ou mot de passe incorrect</p>';
        }
    } else {
        $error = '<p style="color: red;"Vous devez saisir pseudo / mot de passe</p>';
    }
    ?>


    <form action="#" method="POST">
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <div>
            <label for="pseudo">Pseudo</label><br>
            <input type="text" id="name" name="pseudo" id="pseudo">
        </div>
        <div>
            <label for="pwd">password</label><br>
            <input type="password" id="pwd" name="pwd">
        </div>
        <div>
            <input type="submit" value="connexion">
        </div>
    </form>
</body>

</html>