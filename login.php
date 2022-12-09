<?php
session_start();
// On recpuere la congiguration a la bdd
require_once "core/model/config.php";
// On verifie que les champs "name" requis existent et ne sont pas vides
if (isset($_POST["email"]) && isset($_POST["password"]) && $_POST["email"]!="" && $_POST["password"]!="") {
    require_once "core/model/user.php";
    
    // Initilisation des variables
    $email = $_POST["email"];
    $password = $_POST["password"];
    $email = trim($email); // retirer espaces 
    $email = strtolower($email); // email transformé en minuscule
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {   
        $currentUser = User::login($email, $password); // On verifie que l'email et le mdp correspondent en important la methode login de la classe User

        if ($currentUser->id>0) {
            // Garder en session TOUTES les données de l'utilisateur
            $_SESSION["user"] = serialize($currentUser);

            if (isset($_SESSION["user"])) {
                // Recrée l'utilisateur en session
                $utilisateur = unserialize($_SESSION["user"] );
                //exemple bidon
                $id = $utilisateur->id;
                // $pseudo = $utilisateur-> pseudo;
            }

            $_SESSION["user-id"] = $currentUser->id; // on definit $_SESSION["user-id"] en tant que id de la session
            $_SESSION["user"] = $currentUser->email; // // on definit $_SESSION["user"] en tant que mail de la session
            header('Location: home.php'); // On redirige vers la page d'accueil
        } else {
            // header('Location: connect.php?login_err=password');
        }
    } else {
        echo "Pas le bon format d'email";
    }
}
