<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/resgister.css">
        <title>Inscription</title>
    </head>
    <body>
                <?php
                    if(isset($_GET['reg_err']))
                    {
                        $err = htmlspecialchars($_GET['reg_err']);

                        switch($err)
                        {
                            case 'success':
                                ?>
                                    <div class="alert alert-success">
                                        <strong>Succès </strong>inscription réussie !
                                    </div>
                                <?php
                            break;

                            case 'password':
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur </strong>mot de passe différent
                                    </div>
                                <?php
                            break;

                            case 'email':
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur </strong>email non valide
                                    </div>
                                <?php
                            break;

                            case 'email_length':
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur </strong>email trop long
                                    </div>
                                <?php
                            break;

                            case 'pseudo_length':
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur </strong>pseudo trop long
                                    </div>
                                <?php
                            break;

                            case 'already':
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur </strong>compte déjà existant
                                    </div>
                                <?php
                        }
                    }
                ?>
            <div class="divtitle2">
            <p class="title2">Bienvenue sur Slash!</p>  
            </div>
            <form action="inscription_traitement.php" method="post">    
            <input class="text-input3" type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required>      
            <input class="text-input4" type="text" id="email" name="email" placeholder="Entrez votre email" required>
            <input class="text-input5" type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>      
            <input class="text-input6" type="password" id="confirm_password" name="password_retype" placeholder="Confirmez votre mot de passe" required>
            <input type="submit" value="Inscription" class="btn-input">
            </form>
            <p class="p2">Ou connectez-vous avec :</p>
            <img class="icons" src="img/icons.svg" alt="">
            <p class = "p3" id="p3">Vous avez déjà un compte?<a href="index.php"><span>Connexion</span></a></p>
        
        <script src="js/register.js"></script>
    </body>
</html>