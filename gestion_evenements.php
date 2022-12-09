<?php 
    session_start();
    
    require_once "core/model/config.php";
    require_once "core/model/user.php";
    require_once "core/model/tache.class.php";
    require_once "core/model/event.class.php";

    $listTaches = Tache::findAll();
    $eventData = Event::findItemByJoint();

    // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
    }
    
    $user = User::findByiD($_SESSION["user-id"]);
    $userTache = Tache::findUserTask($user->id);
    ?>

<!doctype html>
<html lang="fr">
    <head>
        <title>Mes Projets</title>
        <link rel="shortcut icon" type="image/png" href="img/img_accueil.png" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/events.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" defer></script><script  src="js/doughnut.js" defer></script>
    </head>

    <body>
        <main class="main mb-50">
            <h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
            <h1>Gestion des projets </h1>
            <div class="hevent">
                <h3>Ma liste de projets :</h3>
            </div>
            <?php foreach ($eventData as $item) : ?>    
            <div id="event" style= "background-color:<?= $item->couleur?>;">
                <div class="events">
                    <p class="text-tache"><?= $item->nom_evenement; ?></p>
                </div>
                <div class="metier">
                    <p>Metier : <?= $item->nom; ?></p>
                    <div class="jobimg" style= 'background-image: url("img/img-metier/<?= $item->icone?>");'></div>
                </div>
                <div class="taches">
                    <div class="cadreTache" style= 'background-image: url("img/img-tache/<?= $item->image?>");'></div>
                    <div class="liens">
                        <a class="btnEvent" href="taches.php">Ajouter une tache</a>
                        <a class="btnEvent" href="gestion_taches.php">Afficher les taches</a>
                    </div>
                </div>
                <div class="recette">
                    <p>Recette</p>
                    <p>0.00</p>
                    <a class="btnEvent" href="">Modifier</a>
                </div>
                <div class="depense">
                    <p>Dépense</p>
                    <p>0.00</p>
                    <a class="btnEvent" href="">Modifier</a>
                </div>
            </div>

            <?php endforeach ?>
            <?php include "footer.php"; ?> 
        </main>