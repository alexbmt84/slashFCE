<?php

    namespace PHPMailer\PHPMailer;

    if(isset($_POST["email-forget"]) && $_POST["email-forget"] !="") {
            require_once "vendor/phpmailer/phpmailer/src/PHPMailer.php";
            require_once "vendor/phpmailer/phpmailer/src/SMTP.php";
            require_once "vendor/phpmailer/phpmailer/src/Exception.php";

            try {
                // Tentative de création d’une nouvelle instance de la classe PHPMailer
                $mail = new PHPMailer (true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                // Informations personnelles
                $mail->Host = "smtp.gmail.com";
                $mail->Port = "587";//ou 465
                $mail->Username = "backslateslasher@gmail.com";
                $mail->Password = "jpyalkonvdwxzxcy";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

                // Expéditeur
                $mail->setFrom('contact@gmail.com', 'slasher');
                // Destinataire dont le nom peut également être indiqué en option
                $mail->addAddress('$_POST["email-forget"]', 'toto');
                // // Copie
                // $mail->addCC('info@exemple.fr');
                // // Copie cachée
                // $mail->addBCC('info@exemple.fr', 'nom');
                // (…)
                $mail->isHTML(true);
                // Betreff
                $mail->Subject = "Slash - Recuperation de votre mot de passe";
                // HTML-Inhalt
                $link="http://localhost/slash/connect.php?token=$token";
                $mail->Body = '<h1>Slasher</h1> vous avez perdu votre mot de passe, cliquez sur ce <a href="$link">lien</a> pour changer votre MDP';
                $mail->AltBody = 'Slasher, vous avez perdu votre mot de passe, copiez ce $link pour changer votre MDP';
                // Ajouter une pièce jointe
                // $mail->addAttachment("/home/user/Desktop/image.png", "image.png");

                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                $mail->send();


            } catch (Exception $e) {
                    echo "Mailer Error: ".$mail->ErrorInfo;
                    die();
            }
        } 
        if(!empty($_GET['u'])){
            $token = htmlspecialchars(base64_decode($_GET['u']));
            $check = $bdd->prepare('SELECT * FROM password_recover WHERE token_user = ?');
            $check->execute(array($token));
            $row = $check->rowCount();

            if($row == 0){
                echo "Lien non valide";
                die();
            }
        }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/main.css">
        <title>Connexion</title>

    </head>
    <body>
        <main id="restorePass" >
            <h2>Merci de saisir votre nouveau mot de passe !</h2>
            <form action="password_change_post.php" method="POST" class="frm frm-gap">
                <input type="hidden" name="token" value="<?php isset($_GET["token"])? $_GET["token"]:""; ?>"  />
                <input class="text" type="password" id="password" name="password" placeholder="Nouveau mot de passe" required>
                <input class="text" type="password" id="password" name="password_repeat" placeholder="Confirmez votre nouveau votre mot de passe" required>
                <button type="submit" class="btn"><label for="chk2">Modifier</label></button>
            </form>
        </main>
    </body>
</html>