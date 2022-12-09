<?php
session_start();

require_once "core/model/config.php";
require_once "core/model/user.php";
include("reporting_script.php");

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
  <title>Formulaire évènements</title>
  <link rel="stylesheet" href="css/doughnut.css">
  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" defer></script><script  src="js/reporting.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" defer></script><script  src="js/reportingb.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" defer></script><script  src="js/reporting2.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" defer></script><script  src="js/reporting3.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js" integrity="sha512-Tfw6etYMUhL4RTki37niav99C6OHwMDB2iBT5S5piyHO+ltK2YX8Hjy9TXxhE1Gm/TmAV0uaykSpnHKFIAif/A==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

</head>

<body onload="updateChart()">
<h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
<h1>Reporting</h1>
<div class="reporting">

  <section class="chart2" id="chartContainer">
            <figure class="chart__figure2" id="chart__figure2">
                      <canvas class="chart__canvas" id="chartCanvas5" width="100" height="100" aria-label="doughnutChart" role="img"></canvas>
                      <!-- <button onclick="updateChart2()">Fetch now</button> -->
            </figure>
          </section>

  <section class="chart2" id="chartContainer">
            <figure class="chart__figure2" id="chart__figure">
                      <canvas class="chart__canvas canvas1" id="chartCanvas" width="" height="" aria-label="doughnutChart" role="img"></canvas>
                      <!-- <button onclick="updateChart()">Fetch now</button> -->
            </figure>
          </section>
  <section class="chart2" id="chartContainer">
            <figure class="chart__figure2" id="chart__figure2">
                      <canvas class="chart__canvas" id="chartCanvas2" width="100" height="100" aria-label="doughnutChart" role="img"></canvas>
                      <!-- <button onclick="updateChart2()">Fetch now</button> -->
            </figure>
          </section>

  <section class="chart2" id="chartContainer">
            <figure class="chart__figure2" id="chart__figure3">
                      <canvas class="chart__canvas" id="chartCanvas3" width="" height="" aria-label="doughnutChart" role="img"></canvas>
                      <!-- <button onclick="updateChart3()">Fetch now</button> -->

            </figure>
  </section>
  
  <section class="chart3" id="chartContainer">
            <figure class="chart__figure2" id="chart__figure4">
                      <canvas class="chart__canvas" id="chartCanvas4" width="230" height="230" aria-label="doughnutChart" role="img"></canvas>
                      <!-- <button onclick="updateChart4()">Fetch now</button> -->
            </figure>
          </section>
</div>
<?php include "footer.php"; ?>