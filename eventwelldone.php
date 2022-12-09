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
    <title>Well done !</title>
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
            <img class="redsuccess" src="img/Successmark.png" alt="">
            <h3>Votre événement à été créé !</h3>
            <button id="btn-orange" class="btnAddTask">Ajouter des tâches</button>
            <button id="btn-orange1" class="btnAddTask" onclick="window.location.href='creation.php';">Retour</button>
            <img class="welldone" src="img/welldonevent.png" alt="">


    </main>