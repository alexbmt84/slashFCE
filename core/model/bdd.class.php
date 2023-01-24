<?php

class Database {

    public static function dbConnection(){ // Méthode de connexion à la base de données
        // Initialisation des variables
        $db_host = "localhost";
        $db_name = "testslash";
        $db_username = "root";
        $db_password = "";
        $dsn_db = 'mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8';

        try{

            $site_db = new PDO($dsn_db, $db_username, $db_password); // Tentative de connexion à la base de données
            $site_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ajout d'une exception définissant les propriétés afin de représenter le code d'erreur et les informations complémentaires.

            return $site_db; // Tout fonctionne, la connexion est établie.

        } catch (PDOException $e){ // Erreur

            echo $e->getMessage(); // Message d'erreur
            exit; 
        }
    }
     
}
