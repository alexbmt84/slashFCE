<?php

session_start();

require_once "../model/config.php";
require_once "../model/user.php";
require_once "../model/tache.class.php";
require_once "../model/event.class.php";
require_once "../model/etat.class.php";
require_once "../model/chrono.php";

$user_data = User::findByiD($_SESSION['user-id']);


if (!empty($_POST) || !empty($_FILES)) {

    $target = "";
  
    if ($_FILES["image_tache"]["name"] != "") {
        $uploadDir = "tacheimg/";
  
        if (!file_exists($uploadDir))
            mkdir($uploadDir);
  
        // chemin vers le fichier téléversé temporaire
        $tmpFile = $_FILES["image_tache"]["tmp_name"];
        $trueName = $_FILES["image_tache"]["name"];
        $target = $uploadDir . basename($trueName);
  
        $autorizedTypes = ["image/png", "image/jpg", "image/jpeg", "image/gif"];
        $typeMime = strtolower(mime_content_type($tmpFile));
  
        if (in_array($typeMime, $autorizedTypes)) {
          if (is_uploaded_file($tmpFile)) {
              if ($_FILES["image_tache"]["size"] < 2000000) {
                  move_uploaded_file($tmpFile, $target);
              } else {
                  echo "Fichier trop gros !";
              }
          }
        } else {
                echo "Type de fichier non autorisé !";
        }
    }
  }


if (isset($_POST["nom_tache"]) && $_POST["nom_tache"] != "") {
    if (!empty($_POST["dateDebut"]) && $_POST["dateDebut"] != "") {

            // TOUT EST OK //    

            $newTask = new Tache();

            $newTask-> label = $_POST["nom_tache"];
            $newTask-> date_debut = $_POST["dateDebut"];
            $newTask-> image = $target;
            $newTask-> id_utilisateur = $user_data->id;
            $newTask->evenement_id = $_POST["select-event"];

            $newTask-> save();
            //Si la création est Ok on renvoie la page :
            header("Location: ../../taskwelldone.php");


    } else {
        // Pas de date de début renseignée
        require_once "../model/alert.class.php";
        $msg = new Alert();
        $msg -> setTitle("Error");
        $msg -> setBody("You need to set a date.");
    }

} else {
    // Pas de date de fin renseignée
    require_once "../model/alert.class.php";
    $msg = new Alert();
    $msg -> setTitle("Error");
    $msg -> setBody("You need to set a date.");

}