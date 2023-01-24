<?php

session_start();

require_once "../model/config.php";
require_once "../model/metier.class.php";
require_once "../model/user.php";
require_once "../model/sphere.class.php";

$user_data = User::findByiD($_SESSION['user-id']);

// $sphere = Sphere::findSpherebyid($_SESSION["user-id"]);

if (!empty($_POST) || !empty($_FILES)) {

    $target = "";
  
    if ($_FILES["image_metier"]["name"] != "") {
        $uploadDir = "uploads/";
  
        if (!file_exists($uploadDir))
            mkdir($uploadDir);
  
        // chemin vers le fichier téléversé temporaire
        $tmpFile = $_FILES["image_metier"]["tmp_name"];
        $trueName = $_FILES["image_metier"]["name"];
        $target = $uploadDir . basename($trueName);
  
        $autorizedTypes = ["image/png", "image/jpg", "image/jpeg"];
        $typeMime = strtolower(mime_content_type($tmpFile));
  
        if (in_array($typeMime, $autorizedTypes)) {
          if (is_uploaded_file($tmpFile)) {
              if ($_FILES["image_metier"]["size"] < 2000000) {
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


if (isset($_POST["nomMetier"]) && $_POST["nomMetier"] != "") {

    if (!empty($_POST["radio"])) {

            // TOUT EST OK //    

            $newJob = new Metier();

            $newJob-> nom = $_POST["nomMetier"];
            $newJob-> couleur = $_POST["radio"];
            $newJob-> icone = $target;
            $newJob-> id_sphere = $_POST["radio_sphere"];
            $newJob-> id_utilisateur = $user_data->id;
            $newJob-> addJob();
            //Si la création est Ok on renvoie la page :
            header("Location: ../../jobwelldone.php");


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