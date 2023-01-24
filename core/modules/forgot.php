<?php 
    require_once '../model/config.php';

    if(!empty($_POST['email'])) {

        $email = htmlspecialchars($_POST['email']);

        $check = $bdd->prepare('SELECT token FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row){

            $token = bin2hex(openssl_random_pseudo_bytes(24));
            $token_user = $data['token']; // attention longueur du token : 128, prevoyez un varchar 130 dans votre table si vous utilisez les tokens du système d'inscription

            $insert = $bdd->prepare('INSERT INTO password_recover(token_user, token) VALUES(?,?)');
            $insert->execute(array($token_user, $token));

            $link = 'recover.php?u='.base64_encode($token_user).'&token='.base64_encode($token);

            echo "<a href='$link'>Lien</a>";

        } else {

            echo "Compte non existant";
            #header('Location: ../index.php');
            #die();
        }
    }