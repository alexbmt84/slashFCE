<?php

session_start();

require_once "../model/config.php";
require_once "../model/user.php";
require_once "../model/event.class.php";
require_once "../model/recettes_depenses.class.php";


$user_data = User::findByiD($_SESSION['user-id']);


if (isset($_POST["recette"]) && $_POST["recette"] != "") {

    if (isset($_POST["depense"]) && $_POST["depense"] != "") {

        $recette = $_POST["recette"];
        $recette = str_replace(",", ".", $recette);
        $recette = number_format($recette,2);

        $depense = $_POST["depense"];
        $depense = str_replace(",", ".", $depense);
        $depense = number_format($depense,2);

        $newRecette = new Recette();
        
        $newRecette-> evenement_id = $_POST["select-event"];
        $newRecette-> recette = $recette;
        $newRecette-> depense = $depense;
        $newRecette-> id_utilisateur = $user_data->id;


        $newRecette-> creerRecette();

        header("Location: ../../gestion_taches.php");  

    } else {
    // Pas de date de fin renseignée
    require_once "../model/alert.class.php";
    $msg = new Alert();
    $msg -> setTitle("Error");
    $msg -> setBody("Tous les champs ne sont pas remplis.");
    }

} else {
    // Pas de date de fin renseignée
    require_once "../model/alert.class.php";
    $msg = new Alert();
    $msg -> setTitle("Error");
    $msg -> setBody("Tous les champs ne sont pas remplis.");
}