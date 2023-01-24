<?php

    require_once 'bdd.class.php';

    class User { // Majuscule a la premiere lettre du nom de la classe
        private int $id; // propriete id la classe User
        private string $pseudo;
        private string $email;
        private string $password;
        private ?string $avatar;
        private ?string $token;
        private Datetime $dateInscription; // sans underscore pour eviter les conflits avec la bdd
        private ?Datetime $dateLogin;

        public function __construct() { // Constructeur d'utilisateur ($this = de cette classe) 
            $this->id = 0;
            $this->pseudo = "";
            $this->email = "";
            $this->password = "";
            $this->avatar = "";
            $this->token = "";
            $this->dateInscription = new Datetime();
            $this->dateLogin = new Datetime();
        }

        public function __get($property) { // GET date d'unscription et de dernière connexion
            if ($property == "date_inscription") {
                return $this->dateInscription;
            } else if ($property == "last_login") {
                return $this->dateLogin;
            }else {
                return $this->$property; 
              }
        }

        public function __set($property, $value) { // SET date d'unscription et de dernière connexion
            if ($property == "date_inscription") {
                $this->dateInscription = new Datetime($value);
            } else if ($property == "last_login") {
                $this->dateLogin = new Datetime($value);
            } else {
                $this->$property = $value; 
             }
        }

        public function __toString() { 
            return $this-> pseudo;
        }

        /*************************************************** Update last_login  ***********************************************************************/

        private static function updateLogDate(int $id, PDO $connexion) {
            $sql = "UPDATE utilisateurs SET last_login = CURRENT_TIMESTAMP WHERE id = :id;";
                
        // Connexion à la base de données
            try {  
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $requete = $db_connection->prepare($sql);
                // $requete-> bindParam(":dateLogin", $dateLogin, PDO::PARAM_STR);
                $requete-> bindParam(":id", $id, PDO::PARAM_INT);
                
                return $requete-> execute();
                
            } catch (Exception $exc) {
                // echo $exc-> getMessage();
                return false;
            }
        }

        /*****************************************************************  LOGIN  ***********************************************************************/

        public function getPassword() { // on retourne le champ password de User
            return $this->password;
        }

        public static function login(string $email, string $password) : User {  // méthode login de la classe User

            try {
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                // On regarde si l'utilisateur est inscrit dans la table utilisateurs avec son email
                $check = $db_connection->prepare('SELECT * FROM utilisateurs WHERE email = :email');
                $check->bindParam(':email', $email, PDO::PARAM_STR); // Lie un paramètre à une variable spécifique
                $check->execute(); // Execution de la requete

                $data = $check->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User"); // Génère un tableau des resultats obtenus

                if ($check->rowCount()) { // compte le nombre de ligne recuperees par la requete sql
                    $user = $data[0]; // La première ligne du tableau $data est maintenant devenue la variable $user
                    if(password_verify($password, $user->getPassword())) // On verifie les mots de passe entre le mot de passe entré et le mdp stocké en base de données (avec la fonction getpassword)
                    {
                        return $user;   // tout est ok on se connecte
                    } else {
                        return new User();
                    }
                   
                } else {
                    return new User();
                }
            
            } catch(Exception $e) {

                return new User();
            }
        }
            /*********************************************************** INSCRIPTION *****************************************************************************/
        
            /**
            * @param void Rien à passer en paramètre !
            * @return bool TRUE in case of success or FALSE in case of failure
            */
            
            public function creerCompte() : bool {
                $email = $this->email;
                $password = $this-> password;
                $pseudo = $this-> pseudo;

                $token = bin2hex(openssl_random_pseudo_bytes(24));
        
                // Requête sql 
                $sql = "INSERT INTO utilisateurs (email, password, pseudo, token) VALUES (:email, :password, :pseudo, :token);";
                
                // Connexion à la base de données
                try {  
                    $db_obj = new Database();
                    $db_connection = $db_obj->dbConnection();

                    $requete = $db_connection->prepare($sql);
                     // Lie un paramètre à une variable spécifique
                    $requete-> bindParam(":email", $email, PDO::PARAM_STR);
                    $requete-> bindParam(":password", $password, PDO::PARAM_STR);
                    $requete-> bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
                    $requete-> bindParam(":token", $token, PDO::PARAM_STR);
                    
                    return $requete-> execute(); // Execution de la requête
                    
                } catch (Exception $exc) {
                    // echo $exc-> getMessage();
                    return false;
                }
            }

        /****************************************************************   EXISTS  ************************************************************************/ 
    
        /**
         * @param string $email Email de l'utilisateur souhaitant se connecter
         * 
         * @return bool TRUE si un compte portant cet email existe déjà, FALSE sinon
         */
        public static function exists(string $email): bool { 
            return false;
        }


        /**************************************************************  FIND BY ID  *********************************************************************/

         /**
         * @param int $id Identifiant de l'utilisateur à retrouver
         * 
         * @return User L'utilisateur qui possède l'identifiant fourni en argument
         */
        public static function findByiD(int $id): User {
            // Requête SQL à executer
            $sql = "SELECT * FROM utilisateurs WHERE id = :id;";

            try {
                // connexion à la base de données
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $requete = $db_connection->prepare($sql); 
                $requete-> bindParam(":id", $id, PDO::PARAM_INT); // Lie un paramètre à une variable spécifique
                
                $requete-> execute(); // execution de la requete

                $resultats = $requete-> fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User"); // Génère un tableau des resultats obtenus

                if (count($resultats) > 0) { // compte les resultats entre dans la condition si $resultats > 0
                    return $resultats[0]; // Retourne la première ligne du tableau $resultats
                } else {
                   return new User();
                }

            } catch (Exception $exc) {
                //   echo $exc-> getMessage();

                return new User();
            }
        }

        /*********************************************************** IMAGE EXISTS **********************************************************************/

        public static function check_image_exists($url, $default = 'default.jpg') { 

            $url = trim($url);
            $info = @getimagesize($url);

            if ((bool) $info) {
                return $url;
            } else {
                return $default;
            }
        }

        /**************************************************************  FIND ALL  *********************************************************************/ 
        public static function findAll() : array {
            $sql = "SELECT * FROM utilisateurs ORDER BY pseudo ASC;"; // requete sql pour recuperer tous les utilisateurs et les trier par ordre alphabetique (par pseudo)
            
            
            try {
                // Connexion à la bdd
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();
                // preparation de la requete
                $query = $db_connection->prepare($sql);
                
                if ($query-> execute()) { // execution de la requete
                    $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "User"); // Définit le mode de récupération par défaut pour cette requête 
                    $resultats = $query-> fetchAll(); // Génère un tableau des resultats obtenus
                    
                    return $resultats; // retourne les resultats
                } else {
                    return array(); // renvoie un tableau si l'execution de la requete n'a pas fonctionné
                    
                }
                
            } catch (Exception | PDOException | Error $e){
                die($e-> getMessage()); 
                // return array();
            }  
        }

        /**************************************************************  Delete user  *********************************************************************/ 
       
        /**
         * delete()
         * Supprimer un utilisateur de la base de données.
         * @return bool true en cas de succès, false en cas d'echec.
         */

        public function delete() : bool {
            
            $sql = "DELETE FROM utilisateurs WHERE id = :id;"; // requete sql
            
            try {
                
                // connexion a la bdd
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $query = $db_connection->prepare($sql); // prepare la requete sql
                $query->bindParam(":id", $this->id, PDO::PARAM_INT); // // Lie un paramètre à une variable spécifique

                return $query-> execute(); // execute la requete sql
                
                        
            } catch (Exception | PDOException | Error $e){
                die($e-> getMessage());
                return false;
            }
            return false;
        }
    }    

    
