<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";

if(!isset($_SESSION['user'])){
  header('Location:index.php');
}

$user = User::findByiD($_SESSION["user-id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Management</title>
  <link rel="stylesheet" href="css/doughnut.css">
  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
<h1>Management</h1>
<?php include "footer.php"; ?>