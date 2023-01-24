<?php 

    // use PDOException;
    class Role {
        private int $id;
        private string $label;

        /****************************************************  CONSTRUCTEUR DE CLASSE  *******************************************************************/

        public function __construct(int $id = 0, string $label = "") {
            $this->id = $id;
            $this->label = $label;

        }

        public function __set($property, $value) {
            $this->$property = $value;
            
        }

        public function __get($property) {
            return $this->$property;    
        }

        /************************************************************  FIND ALL ***********************************************************************/

        /**
         * finAll persmet de lister les roles stockés en base de données 
         * @param void
         * @param array Tableau listant les roles existants
         * 
         */

        public static function findAll(): array {
            require_once "core/model/bdd.class.php"; // ici ou en haut ?

            $sql = "SELECT * FROM roles ORDER BY id ASC";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $request = $db_connection->prepare($sql);
                $request->execute();

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);

                return $results;

            } catch (PDOException $exc) {
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }

            
        }
        /************************************************************  MAX ROLES ***********************************************************************/

        /**
         * finAll persmet de lister les roles stockés en base de données 
         * @param void
         * @param array Tableau listant les roles existants
         * 
         */

        public static function maxRole(): array {
            require_once "core/model/bdd.class.php";

            $sql = "SELECT * FROM roles WHERE MAX(id);";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $request = $db_connection->prepare($sql);
                $request->execute();

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);

                return $results;

            } catch (PDOException $exc) {
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }

            
        }

        /************************************************************  FIND BY ID  ***********************************************************************/

        /**
         * findById persmet de lister les roles stockés en base de données 
         * @param int $id l'identifiant du role recherché en bdd
         * @return Role role qui correspond à l'id passé en argument
         * 
         */

        public static function findById(int $id): Role {
            require_once "core/model/bdd.class.php";

            $sql = "SELECT * FROM roles WHERE id = :id";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $request = $db_connection->prepare($sql);
                $request->bindParam(":id", $id, PDO::PARAM_INT);
                $request->execute();

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);

                return $results[0];

            } catch (PDOException $exc) {
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }
        
        }
    }