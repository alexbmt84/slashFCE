<?php 

    // use PDOException;
    require_once 'bdd.class.php';

    class Recette {
        private int $id_recette;
        private float $recette;
        private float $depense;
        private int $evenement_id;
        private int $id_utilisateur;
  
        /************************************************************  CONSTRUCTEUR DE CLASSE  ***********************************************************/

        /**
         * Constructeur de l classe utilisateur 
         * @param int $id_recette soit identifiant de la recette soit 0 si nul
         * @param float $recette, montant des recettes 
         * @param float $depense, montant des depenses
         * @param int $evenement_id, id de l'evenement associé aux recettes et depenses créées
         **/

        public function __construct($id_recette=0, $recette=0.0, $depense=0.0, $evenement_id=0, $id_utilisateur=0) {

            $this->id_recette = $id_recette;
            $this->recette = $recette;
            $this->depense = $depense;
            $this->evenement_id = $evenement_id;
            $this->id_utilisateur = $id_utilisateur;
        }
  

        /***************************************************************  GETTERS / SETTERS **************************************************************/

        public function __set($property, $value) 
            {
                $this->$property =$value;
            }

        public function __get($property) 
            {  
                return $this->$property;
            }

         /**************************************************************  FIND ALL RECETTES DEPENSES ****************************************************************/

        /**
         * finAll persmet de lister les recettes/depenses stockées en base de données 
         * @param void
         * @param array Tableau listant les recettes/depenses existantes
         * 
         */

        public static function findAllRecette(): array { // Création de la méthode findAllrecette() renvoyant un tableau listant les recettes/depenses existantes.
            require_once "bdd.class.php";

            $sql = "SELECT * FROM recette_depense ORDER BY id_recette ASC"; // Requête sql selectionnant toutes les recettes/depenses.

            
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            // Tentative de connexion à la base de données.
            try {
                $request = $db_connection->prepare($sql); // Préparation de la requête sql
                $request->execute(); // Exécution de la requête sql 

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE); // On stocke les résultats dans un tableau.

                return $results; // On retourne les résultats.

                // Erreur de connexion à la base de données.
            } catch (PDOException $exc) {
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }

            
        }

        /************************************************************  FIND RECETTES DEPENSES BY ID  *****************************************************/

        /**
         * findById persmet de lister les recettes/depenses stockées en base de données 
         * @param int $id l'identifiant de la recette/depense recherchée en bdd
         * @return Recette recette/depense qui correspond à l'id passé en argument
         * 
         */

        public static function findIdRecette(int $id_recette): Recette { // Création de la méthode findIdRecette
            require_once "bdd.class.php";

            $sql = "SELECT * FROM recette_depense WHERE id_recette = :id_recette"; // Requête sql

            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();
            // Tentative de connexion à la bdd
            try {
                $request = $db_connection->prepare($sql); // Préparation de la requête
                $request->bindParam(":id_recette", $id_recette, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique.
                $request->execute(); // Exécution de la requête

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE); // Stockage des résultats dans un tableau stocké dans la variable $results.

                return $results[0]; // Retourne la première ligne du tableau $results.

            } catch (PDOException $exc) { // Erreur de connexion à la bdd
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }
        
        }


         /***************************************************************  FIND Recette depense BY event  ***********************************************************/

    public static function findRecetteEvent(int $evenement_id) { // Création de la méthode findRecetteEvent qui retrouve une recette/depense selon l'id de l'événement passé en paramètres.

        $sql = "SELECT * FROM recette_depense WHERE evenement_id=:evenement_id ORDER BY id_recette ASC;"; // Requête sql 
               
        // Tentative de connexion à la bdd
        try {
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $query = $db_connection-> prepare($sql); // Préparation de la requête sql
            $query-> bindParam("evenement_id", $evenement_id, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique.

            if ($query-> execute()) { // Exécution de la requête
                $resultats = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Recette"); // On stocke le tableau des résultats dans la variable $resultats.

                return $resultats; // On retourne les résultats.

            } else {
                return array(); // On retourne un tableau vide.
            }
        } catch (Exception | PDOException | Error $e ) { // Erreur de connexion à la bdd.
            die($e-> getMessage());
            return array();
        }
    }

        
        /********************************************************* CREER UNE RECETTE ********************************************************************/

        /**
        * @param void Rien à passer en paramètre !
        * @return bool TRUE in case of success or FALSE in case of failure
        */
        
        public function creerRecette() : bool { // Méthode de création de recette/depense renvoyant un booléen.
            $recette = $this->recette; // Initialisation des variables ($this = cette classe (Recette)).
            $depense = $this-> depense;
            $evenement_id = $this-> evenement_id;
            $id_utilisateur = $this-> id_utilisateur;
    
            // Requête sql
            $sql = "INSERT INTO recette_depense (recette, depense, evenement_id, id_utilisateur) VALUES (:recette, :depense, :evenement_id, :id_utilisateur);";
            
            try {  
                // Tentative de connexion à la base de données
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();
                
                $requete = $db_connection->prepare($sql); // Préparation de la requête sql
                
                $requete-> bindParam(":recette", $recette, PDO::PARAM_STR); // Lie un paramètre à une variable spécifique
                $requete-> bindParam(":depense", $depense, PDO::PARAM_STR);
                $requete-> bindParam(":evenement_id", $evenement_id, PDO::PARAM_STR);
                $requete-> bindParam(":id_utilisateur", $id_utilisateur, PDO::PARAM_STR);
                
                return $requete-> execute(); // Exécution de la requête
                
            } catch (Exception $exc) { // Echec.
                // echo $exc-> getMessage();
                return false; // Retourne false, la recette/depense n'est donc pas créée.
            }
        }
    }  