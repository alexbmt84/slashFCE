<?php
    session_start();
    require_once "core/model/config.php";
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
        <title>Connexion</title>

    </head>
    <body>

        <div class="formBox">
        <input type="radio" id="chk1" name="a1" style="display: none;">
        <input type="radio" id="chk2" name="a1" style="display: none;">
        <input type="radio" id="chk3" name="a1" style="display: none;">
            <div class="box">
                <div class="top"></div>
                <div class="front">
                    <img class="logo" src="img/logo.png" alt="">
                    <h1>Bonjour!<br>Heureux de vous voir sur Slash!</h1>
                    <form action="login.php" class="frm" method="post">
                        <input class="text" type="email" name="email" placeholder="Entrez votre email" required>      
                        <input class="text" type="password" name="password" placeholder="Entrez votre mot de passe" required>
                        <button class="btn" type="submit">Connexion</button>
                        <label for="chk3" id="btm2">Mot de passe oublié</label>
                        <label for="chk1" id="btm"><span>Vous n'avez pas de compte ? </span>Inscription</label>
                    </form>
    
                    <p>Ou connectez-vous avec :</p>
                    <img class="icons" src="img/icons.svg" alt="">
                </div>
                <div class="right">
    
                    <form action="register_conf.php" class="frm" method="post">
                        <h2>Bienvenue sur Slash!</h2> 
                            <input class="text" type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required>      
                            <input class="text" type="email" id="email" name="email" placeholder="Entrez votre email" required>
                            <input class="text" type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>      
                            <input class="text" type="password" id="confirm_password" name="password_retype" placeholder="Confirmez votre mot de passe" required>
                            <button class="btn" type="submit"><label for="">Inscription</label></button>
                            
                        </form>
                        <p class="p2">Ou connectez-vous avec :</p>
                        <img class="icons" src="img/icons.svg" alt="">
                        <label for="chk2" id="btm"><span>Vous avez déjà un compte ? </span>Connexion</label>
                </div>
                <div class="back">
                </div>
                <div class="left">
                    <img class="logo" src="img/logo.png" alt="">
                    <h2>Mot de passe oublié ?</h2>  
                    <p>Entrez l’adresse email liée à votre compte.</p>
                    <form action="./core/modules/forgot.php" method="post" class="frm">
                        <input class="text" type="email" name="email" placeholder="Entrez votre email" required>
                        <button type="submit" class="btn"><label for="chk2">Envoyer</label></button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>