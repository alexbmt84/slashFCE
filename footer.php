<?php 
require_once "core/model/config.php";
require_once "core/model/user.php";

?> 
    <footer>
      <a href="gestion_evenements.php" class="icon-menu">
        <i class="fa-solid fa-pen-to-square footerIcon"></i>
      </a>
      <a href="planification.php" class="icon-menu">
        <i class="fa-regular fa-calendar-days footerIcon"></i>
      </a>
      <a href="reporting.php" class="icon-menu">
        <i class="fa-solid fa-chart-pie footerIcon"></i>
      </a>
      <a href="creation.php" class="icon-menu">
        <i class="fa-solid fa-circle-plus footerIcon"></i>
      </a>
      <a href="profile.php" class="icon-menu">
        <i class="fa-solid fa-user footerIcon"></i>
      </a>
      <a href="gestion.php" class="icon-menu">
        <i class="fa-solid fa-gear footerIcon"></i>
      </a>
      <a href="deconnexion.php" class="icon-menu">
      <i id="logoutIcon" class="fa-solid fa-right-from-bracket"></i>
      </a>
    </footer>
    
    <script src="js/event.js" defer></script>
    <script src="js/darkmode.js" defer></script>  
    <script src="js/app.js" defer></script>
    <script src="js/img.js" defer></script>
</body>
</html>