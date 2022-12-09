<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/metier.class.php";
require_once "core/model/user.php";

$user_data = User::findByiD($_SESSION['user-id']);


if (isset($_POST["nomEvenement"]) && $_POST["nomEvenement"] != "") {

                // TOUT EST OK //
                require_once "core/model/event.class.php";

                $newEvent = new Event();
                
                $newEvent-> nom_evenement = $_POST["nomEvenement"];
                $newEvent-> nom_client = $_POST["nomClient"];
                $newEvent-> commentaire = $_POST["commentaires"];
                $newEvent-> id_utilisateur = $user_data->id;
                $newEvent-> id_metier = $_POST["select-metier"];


                $newEvent-> creerEvent();

                header("Location: eventwelldone.php");  

} else {
    // Pas de date de fin renseignée
    require_once "core/model/alert.class.php";
    $msg = new Alert();
    $msg -> setTitle("Error");
    $msg -> setBody("You need to set an event name.");

}