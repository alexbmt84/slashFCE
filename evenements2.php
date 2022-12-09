<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";
require_once "footer.php";
require_once "core/model/metier.class.php";
            

if(!isset($_SESSION['user'])){
  header('Location:index.php');
}

// $lsMetier = Metier::findAllMetiers();
$user = User::findByiD($_SESSION["user-id"]);
$userMetier = Metier::findUserMetier($user->id);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire évènements</title>
  <link rel="stylesheet" href="css/events.css">
  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
  <h1>évènements</h1>
  <div class="modal-wrap">
    <div class="modal-header"><span class="is-active bg_orange"></span><span></span><span></span></div>
    <div class="modal-bodies">
      <div class="modal-body modal-body-step-1 is-showing">
        <div class="title">Créez votre d'évènement</div>
        <!-- <form action="add_event.php" method="POST"> -->
          <label class="type">
            <input type="radio" id="radio-pro-1" name="radio" checked/>Professionnel
            <input type="radio" id="radio-perso-1" name="radio" />  Personnel
          </label>
          <input type="text" id="nomEvenement-1" name="nomEvenement" placeholder="Nom de l'évènement" />
          <input type="text" id="nomClient-1"  name="nomClient" placeholder="Nom du client" />
          <textarea id="commentaires-1" name="commentaires" placeholder="Commentaires"></textarea>
          <div class="text-center">
            <button class="button" type="submit">Continuer</button>
          </div>
        <!-- </form> -->
      </div>
      <div class="modal-body modal-body-step-2">
        <!-- <form action="add_event.php" method="POST"> -->
          <?php
          $date = new DateTime();
          $fin = date("Y-m-d H:i", strtotime($date->format("Y-m-d H:i") . ' +1 Hour'));
          ?>
          <input type="hidden" id="radio-2" name="radio" value="">
          <input type="hidden" id="nomEvenement-2" name="nomEvenement" value="">
          <input type="hidden" id="nomClient-2" name="nomClient" value="">
          <input type="hidden" id="commentaires-2" name="commentaires" value="">
          <label>
            <div class="title">Début : <input type="datetime-local" name="dateDebut" id="dateDebut-1" value="<?= $date->format("Y-m-d H:i"); ?>" required></div>
          </label>
          <label>
            <div class="title">Fin : <input type="datetime-local" name="dateFin" id="dateFin-1" value="<?= $fin;?>" required></div>
          </label>
          <div class="text-center fade-in">
            <button class="button" type="submit">Suivant</button>
          </div>
        <!-- </form> -->
      </div>
      <div class="modal-body modal-body-step-3">
        <form action="add_event.php" method="POST">
          <input type="hidden" id="radio-3" name="radio" value="">
          <input type="hidden" id="nomEvenement-3" name="nomEvenement" value="">
          <input type="hidden" id="nomClient-3" name="nomClient" value="">
          <input type="hidden" id="commentaires-3" name="commentaires" value="">
          <input type="hidden" name="dateDebut" id="dateDebut-2">
          <input type="hidden" name="dateFin" id="dateFin-2">
          
          <div class="title">Recettes : <input type="text" name="recettes"></div>
          <div class="title">Dépenses : <input type="text" name="depenses"></div>
          <textarea id="commentaire" placeholder="Commentaires" name="commentaire"></textarea>

          <select name="event" id="event">

            <?php

              foreach ($userMetier as $item) {
                echo "<option class='center-box' value='{$item->metier_id}'>{$item->nom}</option>";
              }
            ?>

          <div class="text-center">
            <button class="button" type="submit">Valider</button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="text-center">
    <div class="rerun-button">Créer un nouvel évènement</div>
  </div>

  <?php include "footer.php"; ?>