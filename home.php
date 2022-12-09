<?php 
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";

$user = User::findByiD($_SESSION["user-id"]);

if (!isset($_SESSION['user']))
  header('Location:login.php');

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.145.0/three.min.js" integrity="sha512-mElAVmOZp/n8OKao194p++kIARCbLKnf/pdVTVI+ZkxL0Rmyw6p5C4kcLd67l2WdvfyBqFe6dI4lR3m++xhdnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <header>
      <img class="logo" src="img/logo.png" alt="logo">
      <h2>Bienvenue <?= $user->pseudo;?></h2>
      <p>Que voulez vous faire ?</p>
    </header>
    <main>
      <div class="scene-polygon">
        <div class="pol-wrap">
          <div class="pol-dodecahedron">
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <img class="pentagon-img"src="img/logomini.png" alt="">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
            <div class="pol-pentagon">
              <div class="pol-pentagon-inner"></div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php 
      include "footer.php";
    ?>
    <script src="js/polygon.js"></script>
  </body>
</html>
