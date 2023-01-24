<?php
session_start(); // On démarre une session.
session_regenerate_id(true); // Update de l'id de la session avec un nouvel id généré par celle-ci.

// Fichier dont on à besoin.
require 'core/model/bdd.class.php'; 
require 'core/model/user.php';
require 'core/model/event.class.php';
require 'core/model/role.class.php';
require 'core/model/tache.class.php';
require 'core/model/alert.class.php';

//************** CREATION METHODES ****************//

// FOR DATABASE CONNECTIONS

$db_obj = new Database();
$db_connection = $db_obj->dbConnection();

// FOR NEW USER OBJECT

$user_obj = new User($db_connection);


// FOR NEW EVENT OBJECT

$frnd_obj = new Event($db_connection);

?>