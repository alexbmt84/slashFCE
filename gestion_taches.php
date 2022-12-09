<?php 
    session_start();
    
    require_once "core/model/config.php";
    require_once "core/model/user.php"; // ajout connexion bdd
    require_once "core/model/tache.class.php";

    $listTaches = Tache::findAll();

    // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
    }
    
    $user = User::findByiD($_SESSION["user-id"]);
    $userTache = Tache::findUserTask($user->id);
    $tachesData = Tache::findItemByJoint($user->id);

    if (isset($_POST["action"])) {
        switch ($_POST["action"]) {
            case "start":
                $tache = Tache::findTaskById($_POST["tache"]);
                $tache-> loadAllTimers();
                $tache-> start();
                break;
            case "pause":
                $tache = Tache::findTaskById($_POST["tache"]);
                $tache-> loadAllTimers();
                $tache-> pause();
                break;
            case "stop":
                $tache = Tache::findTaskById($_POST["tache"]);
                $tache-> loadAllTimers();
                $tache-> stop();
                break;
            case "remove-timer":
                $timer = Tache::findTaskById($_POST["timer"]);
                $timer-> delete();
                break;
            case "delete":
                $tache = Tache::findTaskById($_POST["tache"]);
                $tache-> loadAllTimers();
                $tache-> delete();
                break;
            default:
                break;
        }
    }

    ?>
<!doctype html>
<html lang="fr">
    <head>
        <title>Plannification</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/doughnut.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" defer></script><script  src="js/doughnut.js" defer></script>
    </head>
        <body>
        <main class="main">
            <h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
            <h1>Planification</h1>
            <section class="chart" id="chartContainer">
			    <figure class="chart__figure" id="chart__figure">
                    <canvas class="chart__canvas rouge" id="chartCanvas" width="160" height="160" aria-label="doughnutChart" role="img"></canvas>
                    <figcaption class="chart__caption">
                        Excellent ! <span>Vous êtes sur la bonne voie !</span>
                    </figcaption>
			    </figure>
		    </section>
            <div class="event">
                <h3>Taches du jour</h3>
            </div>
                
            <div class="eventGrid">
                <?php foreach ($tachesData as $tache) : 
                    $tache->loadAllTimers() ?>
               
                    <div class="tache tache-pro" style= "background-color:<?= $tache->couleur?>; <?php $tache->couleur ?>">
                        <div class="cadreMetier">
                            <img class="img-metier" src="core/modules/<?= $tache->icone; ?>" alt="">
                        </div>
                        <p class="text-tache"><?= $tache->dateDebut-> format("H:i"); ?></p>
                        <p class="text-tache"><?= $tache->label; ?></p>
                        <div class="cadreTache">
                            <img class="img-tache" src="core/modules/<?= $tache->image; ?>" alt="">
                        </div>
                        <?php
                            if ($tache-> etat == Etat::ATTENTE) echo "<p class='etat-tache'>En attente</p>";
                            if ($tache-> etat == Etat::ACTIF) echo "<span class='etat-tache'>Active</span>";
                            if ($tache-> etat == Etat::PAUSE) echo "<span class='etat-tache'>En pause</span>";
                            if ($tache-> etat == Etat::STOP) echo "<span class='etat-tache'>Terminée</span>";
                        ?>
                        <div class="etat">

                            <form action="?#tache-<?= $tache-> tache_id; ?>" method="post">
                                <input type="hidden" name="tache" value="<?= $tache-> tache_id ?>">
                                <input type="hidden" name="action" value="start">
                                <button class="btn btn-sm btn-dark <?= $tache-> etat==Etat::ATTENTE||$tache-> etat==Etat::PAUSE ? "":"disabled"; ?>">
                                    <i class="fa-regular fa-circle-play"></i>
                                </button>
                            </form>

                            <i class="fa-regular fa-circle-pause"></i>
                            <i class="fa-regular fa-circle-stop"></i>

                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <?php include "footer.php"; ?> 

        </main>