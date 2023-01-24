<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/resgister.css">
        <title>Mot de passe oublié</title>
    </head>
    <body>
        <p class="title2">Mot de passe oublié ?</p>  
        <p class="p4">Entrez l’adresse email liée à votre compte.</p>
        <form action="forgot.php" method="POST">
        <input class="text-input1" type="email" name="email" placeholder="Entrez votre email" required>      
        <input type="submit" value="Envoyer" id="btn" >
        </form>
        <p class="p2">Ou connectez-vous avec :</p>
        <img class="icons" src="img/icons.svg" alt="">
        <p class = "p6">Mot de passe retrouvé?<a href="index.php"><span>Login</span></a></p>

    </body>
</html>