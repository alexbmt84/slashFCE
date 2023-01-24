<?php 

    // use PDOException;
    require_once 'bdd.class.php';
    // Création de la classe Event
    class Event {
        private int $evenement_id; // Propriétés de la classe Event
        private string $nom_evenement;
        private string $nom_client;
        private ?string $duree;
        private ?string $commentaire;
        private int $id_utilisateur;
        private int $id_metier;
  
        /************************************************************  CONSTRUCTEUR DE CLASSE  ***********************************************************/

        /**
         * Constructeur de l classe utilisateur 
         * @param int $evenement_id soit identifiant de l'évènement soit 0 si nul
         * @param string $nom_evenement, nom de l'évènement
         * @param string $nom_client, nom du client
         * @param string $duree, duree de l'événement
         * @param string $commentaire
         * @param int $id_metier, le métier lié à l'événement
         **/

        public function __construct($evenement_id=0, $nom_evenement="", $nom_client="", $duree=null, $commentaire= null, $id_utilisateur=0, $id_metier=0) {

            $this->evenement_id = $evenement_id; // $this = cette classe (Event)
            $this->nom_evenement = $nom_evenement;
            $this->nom_client = $nom_client;
            $this->duree = $duree;
            $this->commentaire = $commentaire;
            $this->id_utilisateur = $id_utilisateur;
            $this->id_metier = $id_metier; 

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

         /**************************************************************  FIND ALL EVENTS ****************************************************************/

        /**
         * finAll persmet de lister les évènements stockés en base de données 
         * @param void
         * @param array Tableau listant les évènements existants
         * 
         */

        public static function findAllEvents(): array { // Création de la méthode findAllEvents()
            require_once "bdd.class.php";

            $sql = "SELECT * FROM evenements ORDER BY evenement_id ASC"; // Requête sql selectionnant tous les évènements 

            // Connexion à la base de données
            $db_obj = new Database(); 
            $db_connection = $db_obj->dbConnection(); // Utilisation de la méthode dbConnection() de la classe Database

            try {
                $request = $db_connection->prepare($sql); // Préparation de la requête sql
                $request->execute(); // Execution de la requête sql

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE); // Tableau des résultats obtenus puis stockés dans la variable $results.

                return $results; // Retourne les résultats.

            } catch (PDOException $exc) { // Erreur si la tentative de connexion échoue.
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }

            
        }

        /************************************************************  FIND EVENT BY ID  *****************************************************************/

        /**
         * findById persmet de lister les évènements stockés en base de données 
         * @param int $id l'identifiant de l'évènement recherché en bdd
         * @return Event évènement qui correspond à l'id passé en argument
         * 
         */

        public static function findIdEvent(int $evenement_id): Event { // Création de la méthode findIdEvent() pour retrouver un évènement en fonction de son id. (On passe l'id en paramètres).
            require_once "bdd.class.php";

            $sql = "SELECT * FROM evenements WHERE evenement_id = :evenement_id"; // Requête sql permettant de récuperer l'évènement en fonction de l'id de celui-ci. 

            // Nouvelle connexion à la base de données.
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection(); // Utilisation de la méthode dbConnection() de la classe Database

            try {
                $request = $db_connection->prepare($sql); // Préparation de la requête sql
                $request->bindParam(":evenement_id", $evenement_id, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique
                $request->execute(); // Execution de la requête.

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE); // Tableau des résultats obtenus puis stockés dans la variable $results.

                return $results[0]; // Retourne la première ligne du tableau stocké dans la variable $results.

            } catch (PDOException $exc) { //Erreur si la tentative de connexion échoue.
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }
        
        }


        /***************************************************************  FIND Event BY USER  ***********************************************************/
        /**
         * findUserEvent permet de lister les évènements liés à l'utilisateur stockés en base de données.
         * @param int $id_utilisateur l'identifiant de l'utilisateur recherché en bdd.
         * @return Event évènement qui correspond à l'id passé en argument.
         * 
         */

        public static function findUserEvent(int $id_utilisateur) { // Création de la méthode findUserEvent() pour retrouver un évènement en fonction de l'id de l'utilisateur. (On passe son id en paramètres).

            $sql = "SELECT * FROM evenements WHERE id_utilisateur=:id_utilisateur ORDER BY id_metier ASC;"; // Requête sql selectionnant tous les évènements en fonction de l'utilisateur.
            
            // Tentative de connexion à la base de données
            try {

                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection(); // Utilisation de la méthode dbConnection() de la classe Database.

                $query = $db_connection-> prepare($sql); // Préparation de la requête sql.
                $query-> bindParam("id_utilisateur", $id_utilisateur, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique.

                if ($query-> execute()) { // Si la requête est exécutée..
                    $resultats = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Event"); // On stocke les résulats obtenus dans un tableau, puis on stocke celui-ci dans une variable $resultats.

                    return $resultats; // Retourne les résultats.
                } else {
                    return array(); // Retourne un tableau vide.
                }
            } catch (Exception | PDOException | Error $e ) { //Erreur si la tentative de connexion échoue.
                die($e-> getMessage());
                return array();
            }
        }

        
        /********************************************************* CREER UN EVENEMENT ********************************************************************/

        /**
        * @param void Rien à passer en paramètre !
        * @return bool TRUE in case of success or FALSE in case of failure
        */
        
        public function creerEvent() : bool { // Création de la méthode creerEvent afin de créer un nouvel évènement.
            $nom_evenement = $this->nom_evenement; // initialisation des variables ($this = cette classe (Event)).
            $nom_client = $this-> nom_client;
            $duree = $this-> duree;
            $commentaire = $this-> commentaire;
            $id_utilisateur = $this-> id_utilisateur;
            $id_metier = $this-> id_metier;
    
            // Requête sql afin d'insérer les éléments en base de données
            $sql = "INSERT INTO evenements (nom_evenement, nom_client, duree, commentaire, id_utilisateur, id_metier) VALUES (:nom_evenement, :nom_client, :duree, :commentaire, :id_utilisateur, :id_metier);";
            
            // Tentative de connexion à la base de données.
            try {  
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection(); // Utilisation de la méthode dbConnection() de la classe Database.
                
                $requete = $db_connection->prepare($sql); // Préparation de la requête sql.
                 
                $requete-> bindParam(":nom_evenement", $nom_evenement, PDO::PARAM_STR); // Lie un paramètre à une variable spécifique.
                $requete-> bindParam(":nom_client", $nom_client, PDO::PARAM_STR);
                $requete-> bindParam(":duree", $duree, PDO::PARAM_STR);
                $requete-> bindParam(":commentaire", $commentaire, PDO::PARAM_STR);
                $requete-> bindParam(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
                $requete-> bindParam(":id_metier", $id_metier, PDO::PARAM_INT);
                
                return $requete-> execute(); // Exécution de la requête.
                
            } catch (Exception $exc) { // Erreur si la tentative de connexion échoue.
                // echo $exc-> getMessage();
                return false; // False, le compte n'est pas créé.
            }
        }

        /***************************************************************  FIND ITEM BY JOINT  ***********************************************************/

        public  static function findItemByJoint() {
            require_once "core/model/bdd.class.php";

            $sql = "SELECT metiers.couleur, metiers.icone, metiers.nom, evenements.evenement_id, evenements.nom_evenement, taches.label, taches.image FROM metiers
            INNER JOIN evenements on metiers.id_metier=evenements.id_metier 
            INNER JOIN taches on evenements.evenement_id=taches.evenement_id 
            WHERE evenements.evenement_id= evenements.evenement_id; ";
                    
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                try {
                    $request = $db_connection->prepare($sql);


                    $request->execute();

                    $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);

                    return $results;

                } catch (PDOException $exc) {
                    echo "<h1>Erreur</h1>";
                    echo "<p>" . $exc->getMessage() . "</p>";
                }
        }
}