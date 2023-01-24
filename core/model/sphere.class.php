<?php

require_once "../model/bdd.class.php";

class Sphere {
    private int $sphere_id;
    private string $label;


    /*************************constructeur***************************************** */

    /**
     * constructeur de la classe Sphère
     * @param int $id soit identifiant de la sphère 
     * @param string $label, label representant la sphère pro ou perso
     */

    public function __construct($sphere_id=0, $label="") {

        $this->sphere_id = $sphere_id;
        $this->label = $label;
    }

    /************************************ GETTER / SETTER *************************/
    public function __get($property) {
        return $this-> $property;
    }

    public function __set($property, $valeur) {
        return $this-> $property = $valeur;
    }

    /*****************************************************************  Find sphere by id  *****************************************************************/

    /**
     * findSpherebyid permet de lister les spheres sockées en base de données
     * @param int $id l'identifiant de la sphere en BDD
     * @return Sphere Sphere qui correspond à l'id passé en enregistrement
     */

    public static function findSpherebyid(int $sphere_id): Sphere // Création d'une fonction  afin de rerouver une sphère en fonction de son id
    {
        require_once "core/model/bdd.class.php"; // Importation de la base de données

        $sql = "SELECT * FROM spheres WHERE sphere_id = :sphere_id"; // requête SQL afin de retrouber une sphère en fonction de son id

        try {
            // Nouvelle tentative de connexion à la base de données
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $requete = $db_connection->prepare($sql); // Préparation de la requête sql
            $requete->bindParam(":sphere_id", $sphere_id, PDO::PARAM_INT); // On lie une paramètre à une variable spécifique
            $requete->execute(); // Exécution de la requête

            $resultats = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE); // // On stocke les résulats obtenus dans un tableau, puis on stocke celui-ci dans une variable $resultats.

            return $resultats[0];  // Retourne la première ligne du tableau stocké dans la variable résultats.
        } catch (PDOException $exc) { // Erreur de connexion, on retourne une erreur
            echo "<h1>Erreur</h1>";
            echo "<p> .$exc-> getMessage() . </p>";
            die();
        }
    }



    /**************************************************  FIND ALL ********************************************************************************/


        /**
         * static findAll()
         * Trouve toutes les sphères stockées en base de données.
         * @return Sphere tableau contenant toutes les sphères ou tableau vide.
         */

        public static function findAll(): ?array { // Création de la méthode findAllEvents()
            $sql = "SELECT FROM spheres ORDER BY sphere_id ASC"; // Requête sql selectionnant toutes les sphères 

            try {
                // Tentative de connexion à la base données
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $query = $db_connection->prepare($sql); // Préparation de la requête SQL

                if ($query-> execute()) { // Exécution de la requête SQL
                    $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Sphere"); // On définit le mode de "fetch"
                    $results = $query-> fetchAll(); // Tableau des résultats obtenus puis stockés dans la variable $results.

                    return $results; // On retourne les résultats
                } else {
                    return null; // On retourne un resultat vide
                }

            } catch (Exception|Error $e) {
                return null; // Connexion échouée, erreur
            }
        }
}