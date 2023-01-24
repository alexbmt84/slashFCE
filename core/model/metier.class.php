<?php

require_once "bdd.class.php";

class Metier { // Création de la classe Metier.
    // Propriétés de la classe Metier.
    private int $id_metier; 
    private string $nom;
    private string $couleur;
    private string $icone;
    private int $id_utilisateur;
    private int $id_sphere;

    /*************************constructeur***************************************** */

    /**
     * constructeur de la classe Metier
     * @param int $id soit identifiant du metier soit 0 si nul
     * @param string $nom, nom du métier
     * @param string $couleur, couleur représentant le métier
     * @param string $icone, icone représentant le métier
     */

    public function __construct($id_metier=0, $nom="", $couleur="", $icone="", $id_utilisateur=0, $id_sphere=0) {

        $this->id_metier = $id_metier;
        $this->nom = $nom;
        $this->couleur = $couleur;
        $this->icone = $icone;
        $this-> id_utilisateur = $id_utilisateur;
        $this-> id_sphere = $id_sphere; 
    }

    /************************************ GETTER / SETTER *************************/
    public function __get($property) {
        return $this-> $property;
    }

    public function __set($property, $valeur) {
        return $this-> $property = $valeur;
    }

    /*************************************AJOUTER UN METIER**************************/

    /**
     * @param void Rien a passer en parametre !
     * @param bool TRUE in case of success or FALSE in case of failure
     */

        public function addJob() : bool { // Création de la méthode addJob() renvoyant un booléen.
            $nomMetier = $this->nom;
            $couleurMetier = $this->couleur;
            $iconeMetier = $this->icone;
            $id_utilisateur = $this->id_utilisateur;
            $id_sphere = $this->id_sphere;

            //
            
            require_once "../model/bdd.class.php";
            $sql = "INSERT INTO metiers (nom, couleur, icone, id_utilisateur, id_sphere) VALUE (:nom, :couleur, :icone, :id_utilisateur, :id_sphere);";

            //connexion a la base de données
            
            try {

                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();
                $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $requete = $db_connection->prepare($sql);
                $requete->bindParam(":nom", $nomMetier, PDO::PARAM_STR);
                $requete->bindParam(":couleur", $couleurMetier, PDO::PARAM_STR);
                $requete->bindParam(":icone", $iconeMetier, PDO::PARAM_STR);
                $requete->bindParam(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
                $requete->bindParam(":id_sphere", $id_sphere, PDO::PARAM_INT);

                return $requete-> execute();
            } catch (Exception $exc) {
                return false;
            }
        }

    /***********************************FIND BY ID***************************************/

    /**
     * @param int $id Identifiant du metier à retrouver
     * @param Metier le metier qui possede l'identifiant en argument
     * 
     */

    public static function findById(int $id_metier) : Metier { // Création de la méthode findById() renvoyant le métier qui possède l'id passé en paramètre.

        //requête sql à exécuter
        $sql = "SELECT * FROM metiers WHERE id_metier = :id_metier;";

        try {
            // Tentative de connexion à la base de données
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            //On prépare la requête sql
            $requete = $db_connection->prepare($sql);
            $requete-> bindParam(":id_metier", $id_metier, PDO::PARAM_INT);

            //On exécute la requete
            $requete-> execute();

            //On récupere les resultats puis on les stocke dans un tableau $resultats.
            $resultats = $requete-> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Metier");

            //On compte les resultats superieur à 0
            if (count($resultats) > 0) {

                return $resultats[0]; // On retourne la première ligne du tableau stocké dans la variable $resultats.

            } else {
                return new Metier();
            }

            //Sinon on retourne un métier vide en echec
        } catch (Exception $exc) {
            return new Metier();
        }
    }

    /**********************************************************************  FIND ALL  *******************************************************************/

    public static function findAllMetiers(): array { // Création de la méthode findAll() renvoyant un tableau des métiers.
        require_once "core/model/bdd.class.php";

        $sql = "SELECT * FROM metiers ORDER BY id_metier ASC"; // Requête sql selectionnant tous les métiers de par ordre d'id.

        // Connexion à la base de données
        $db_obj = new Database();
        $db_connection = $db_obj->dbConnection();

        try {
            $request = $db_connection->prepare($sql); // Préparation de la requête sql 
            $request->execute(); // Exécution de la requête sql

            $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE); // On récupere les resultats puis on les stocke dans un tableau $results.

            return $results; // Retourne les résultats.

        } catch (PDOException $exc) { // Erreur de connexion à la bdd.
            echo "<h1>Erreur</h1>";
            echo "<p>" . $exc->getMessage() . "</p>";
        } 
    }

    /***************************************************************  FIND METIER BY USER  ***********************************************************/

    public static function findUserMetier(int $id_utilisateur) { // Création de la méthode findUserMetier() permettant de retrouver les métiers d'un utilisateur en fonction de son id.

        $sql = "SELECT * FROM metiers WHERE id_utilisateur=:id_utilisateur ORDER BY id_metier ASC;"; // Requête sql qui sélectionne les métiers d'un utilisateur en fonction de son id
                
        try {

            // Tentative de connexion à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $query = $db_connection-> prepare($sql); // Préparation de la requête sql
            $query-> bindParam("id_utilisateur", $id_utilisateur, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique.

            if ($query-> execute()) { // Exécution de la requête sql 
                $resultats = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Metier"); // // On récupere les resultats puis on les stocke dans un tableau $resultats.

                return $resultats; // On retourne les résultats.
            } else {
                return array(); // On retourne un tableau vide.
            }
        } catch (Exception | PDOException | Error $e ) { // Erreur de connexion à la base de données.
            die($e-> getMessage());
            return array();
        }
    }

}