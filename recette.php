<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";
require_once "core/model/event.class.php";
require_once "footer.php";


if(!isset($_SESSION['user'])){
  header('Location:index.php');
}

$user = User::findByiD($_SESSION["user-id"]);
$userEvent = Event::findUserEvent($user->id);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire recettes et dépenses</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/events.css">
  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="crossorigin="anonymous" defer></script>
  <script src="js/photo.js" defer></script>
</head>

<body>
<h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
  <h1>Tâches</h1>
  <div class="modal-wrap">
    <div class="modal-header"><span class="is-active bg_vert"></span><span></span><span></span></div>
    <div class="modal-bodies">
      <div class="modal-body modal-body-step-1 is-showing">
        <div class="title vert">Entrer les recettes et dépenses de votre projet</div>

        

        <form action="core/modules/add_recette.php" method="POST" enctype="multipart/form-data">
        
          <select name="select-event" id="metier">
            <?php
              foreach ($userEvent as $event) {
                echo "<option name='event' class='center-box' value='{$event->evenement_id}'>{$event->nom_evenement}</option>";
              }
            ?>
          </select>
          <input type="text" id="recette" name="recette" placeholder="Recettes" />
          <input type="text" id="depense" name="depense" placeholder="Dépenses" />
          <div class="text-center">
            <button class="button" type="submit">Continuer</button>
          </div>
        </form>  
      </div>
    </div>
  </div>
  <div class="text-center">


  <?php include "footer.php"; ?>