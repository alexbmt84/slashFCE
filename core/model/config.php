<?php

    date_default_timezone_set('Europe/Paris');  // Fuseau horaire par defaut 
    
    try // Tentative de connexion 
    {

        $bdd = new PDO('mysql:host=localhost;dbname=testslash;charset=utf8', 'root', ''); // Connexion à la base de données

    } catch(Exception $e) {
        
        die('Erreur'.$e->getMessage()); // Erreur si la tentative a échouée
    }
