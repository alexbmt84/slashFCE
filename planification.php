<?php
session_start();

require_once 'core/model/config.php';
require_once 'core/model/user.php'; // ajout connexion bdd 
include "footer.php";
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
    header('Location:index.php');
}

$user = User::findByiD($_SESSION["user-id"]);
//$user = unserialize($_SESSION["user"]);

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
    <link rel="stylesheet" href="css/app.css">

</head>

<body>
    <main class="main">
        <h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
        <section class="light">
            <div class="calendar">
                <div class="calendar-header">
                    <span class="month-picker" id="month-picker">February</span>
                    <div class="year-picker">
                        <span class="year-change" id="prev-year">
                            <pre><</pre>
                        </span>
                        <span id="year">2021</span>
                        <span class="year-change" id="next-year">
                            <pre>></pre>
                        </span>
                    </div>
                </div>
                <div class="calendar-body">
                    <div class="calendar-week-day">
                        <div>Dim</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mer</div>
                        <div>Jeu</div>
                        <div>Ven</div>
                        <div>Sam</div>
                    </div>
                    <div class="calendar-days"></div>
                </div>
                <div class="calendar-footer">
                    <div class="toggle">
                        <span>Dark Mode</span>
                        <div class="dark-mode-switch">
                            <div class="dark-mode-switch-ident" onclick="darkMode();"></div>
                        </div>
                    </div>
                </div>
                <div class="month-list"></div>
            </div>
        </section>

        <?php
        require_once "core/model/event.class.php";
        $lsEvent = Event::findAllEvents();
        ?>


        <select name="event" id="event">
            <?php


            foreach ($lsEvent as $item) {
                echo "<option class='center-box' value='{$item->evenement_id}'>{$item->nom_evenement}</option>";
            }
            ?>
    </main>