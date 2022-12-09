<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";
require_once "footer.php";
require_once "core/model/metier.class.php";


if(!isset($_SESSION['user'])){
  header('Location:index.php');
}

// $listMetier = Metier::findAllMetiers();
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
        <div class="title orange">Créez votre d'évènement</div>
          <input type="text" id="nomEvenement-1" name="nomEvenement" placeholder="Nom de l'évènement" />
          <input type="text" id="nomClient-1"  name="nomClient" placeholder="Nom du client" />
          <textarea id="commentaires-1" name="commentaires" placeholder="Commentaires"></textarea>
          <div class="text-center">
            <button class="button" type="submit">Suivant</button>
          </div>
      </div>
      <div class="modal-body modal-body-step-2">
        <form action="add_event.php" method="POST">
            <input type="hidden" id="nomEvenement-2" name="nomEvenement" value="">
            <input type="hidden" id="nomClient-2" name="nomClient" value="">
            <input type="hidden" id="commentaires-2" name="commentaires" value="">
            <h3 class="metier-title" >Choisissez le metier lié à ce projet :</h3>

            <select name="select-metier" id="metier">
              <?php
                foreach ($userMetier as $metier) {
                  echo "<option name='metier' class='center-box' value='{$metier->id_metier}'>{$metier->nom}</option>";
                }
              ?>
            </select>

            <div class="img-form-center">
              <img class="form-img" src="img/jobs.png" alt="image metiers">
            </div>
            <div class="text-center fade-in">
              <button class="button" type="submit">Suivant</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div class="text-center">
    <div class="rerun-button">Créer un nouvel évènement</div>
  </div>

  <?php include "footer.php"; ?>