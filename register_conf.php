<?php
// on recupere la configuration a la bdd
require_once "core/model/config.php";

// On verifie que les champs "name" requis existent et ne sont pas vides
// Verifier que les mots de passe sont identiques
if (isset($_POST["email"]) && $_POST["email"] != "") {
    if (isset($_POST["password"]) && $_POST["password"] != "" && strlen($_POST["password"]) > 1) {
        if ($_POST["password"] == $_POST["password_retype"]) {
            if (isset($_POST["pseudo"]) && $_POST["pseudo"] != "") {

                // TOUT EST OK //
                require_once "core/model/user.php";

                $newUser = new User(); // Constructeur d'un nouvel utiisateur 
                
                $options = ["cost" => 12]; // On initialise les options de cryptage dans une variable

                $newUser-> email = $_POST["email"]; // on définit le "name" email du formulaire comme la propriété mail de newUser
                $newUser-> password = password_hash($_POST["password"], PASSWORD_BCRYPT, $options) ; // // on définit le "name" password du formulaire comme la propriété password de newUser et on crypte le mdp
                $newUser-> pseudo = $_POST["pseudo"]; // // on définit le "name" pseudo du formulaire comme la propriété pseudo de newUser

                if (User::exists($_POST["email"])) { // On verifie que l'email soit valide en important la methode "exists" de la classe User et en lui passant email en paramètres


                } else {
                    $newUser-> creerCompte(); // Tout est ok, on créé le compte à l'aide de la méthohde "creerCompte" de la classe User
                    header("Location: connect.php"); // On redirige
                }

            } else {
                // Pas de prénom renseigné !
                require_once "core/model/alert.class.php";
                $msg = new Alert();
                $msg -> setTitle("Error");
                $msg -> setBody("You need to choose a pseudo.");
            }

        } else {
            // Les mots de passe ne correspondent pas!
            require_once "core/model/alert.class.php";
            $msg = new Alert();
            $msg -> setTitle("Error");
            $msg -> setBody("Passwords doesn't match !");
        }

    } else {
        // Pas de mot de passe rensigné !
        require_once "core/model/alert.class.php";
        $msg = new Alert();
        $msg -> setTitle("Error");
        $msg -> setBody("You need to set a password.");

    }

} else {
    // Pas de mail rensigné !
    require_once "core/model/alert.class.php";
    $msg = new Alert();
    $msg -> setTitle("Error");
    $msg -> setBody("You need to set an email.");

}

 