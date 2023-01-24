<?php
/**
 * Timer : chronomètre représentant une fraction temporelle d'une tâche
 */
    class Chrono { // Classe Chrono
        // Propriétés de la classe chrono
        private int $chrono_id;
        private DateTime $debut;
        private ?DateTime $fin;
        private int $tache_id;

        /**
         * Constructeur avec paramètres facultatifs
         */
        public function __construct($chrono_id=0, $debut="", $fin="", $tache_id=0) {
            $this-> chrono_id = $chrono_id;

            if ($debut != "") {
                try {
                    $this-> debut = new DateTime($debut);
                } catch (Exception | Error $e) {
                    $this-> debut = new DateTime();
                }
            } else {
                $this-> debut = new DateTime();
            }

            if (isset($fin) && $fin != "") {
                try {
                    $this-> fin = new DateTime($fin);
                } catch (Exception | Error $e) {
                    $this-> fin = null;
                }
            } else {
                $this-> fin = null;
            }

            $this-> tache_id = $tache_id;
        }

        /**
         * Accesseurs
         * Setter magique
         */
        public function __set($propriete, $valeur) {
            if ($propriete == "debut") {
                $this-> debut = new DateTime($valeur);
            } else if ($propriete == "fin") {
                if ($valeur != "") {
                    $this-> fin = new DateTime($valeur);
                }
            } else {
                $this-> $propriete = $valeur;
            }
        }

        /**
         * Accesseur
         * Getter magique
         */
        public function __get($propriete) {
            if ($propriete == "debut") {
                return $this-> debut;
            } else if ($propriete == "fin") {
                return $this-> fin;
            } else {
                return $this-> $propriete;
            }
        }

        /**
         * start()
         * Lancement d'une chrono (Timer) : création en base de données et état mis en ATTENTE
         * @return bool booléen marquant le succès ou l'échec de l'enregistrement de la tâche dans la base de données.
         */
        public function start(): bool {
            $sql = "INSERT INTO chrono (tache_id) VALUES (:tache_id);";
            
            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);
                
                $query-> bindParam(":tache_id", $this-> tache_id, PDO::PARAM_INT);
    
                if ($query-> execute()) {
                    $this-> chrono_id = $db_connection-> lastInsertId();
                    return true;
                } else {
                    return false;
                }
            } catch (Exception|Error $e) {
                return false;
            }
        }

        /**
         * stop()
         * Arrêt du dernier chrono actif (Timer) : mise à jour en base de données et état mis en STOP
         * @return bool booléen marquant le succès ou l'échec de l'enregistrement de la tâche dans la base de données.
         */
        public function stop(): bool {
            $sql = "UPDATE chrono SET end = CURRENT_TIMESTAMP WHERE chrono_id = :chrono_id;";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);
                
                $query-> bindParam(":chrono_id", $this-> chrono_id, PDO::PARAM_INT);
    
                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception|Error $e) {
                return false;
            }
        }

        /**
         * findById()
         * Récupération d'un timer depuis la base de données par son identifiant.
         * @param int $chrono_id Identifiant de la tâche à récupérer depuis la base de données.
         * @return Chrono Chrono (Timer) dont l'identifiant est recherché.
         */
        public static function findById(int $chrono_id): ?Chrono {
            $sql = "SELECT * FROM chrono WHERE chrono_id = :chrono_id;";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);

                $query-> bindParam(":chrono_id", $chrono_id, PDO::PARAM_INT);
                
                if ($query-> execute()) {
                    $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Chrono");
                    $result = $query-> fetch();
                    
                    return $result;
                } else {
                    return null;
                }
            } catch (Exception|Error $e) {
                return null;
            }
        }

        /**
         * findById()
         * Récupérer les chronos (Timer) associés à une tâche, par l'identifiant de la tâche.
         * @param int $tache Identifiant de la tâche auquel sont rattachés les Timers.
         * @return array Tableau regroupant les timers associés à la tâche.
         */
        public static function findByTache(int $tache_id): array {
            $sql = "SELECT * FROM chrono WHERE tache_id=:tache_id ORDER BY chrono_id ASC";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);

                $query-> bindParam(":tache_id", $tache_id, PDO::PARAM_INT);
                
                if ($query-> execute()) {
                    $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Chrono");
                    $results = $query-> fetchAll();

                    return $results;
                } else {
                    return array();
                }
            } catch (Exception|Error $e) {
                return array();
            }
        }

        /**
         * delete()
         * Supprimer la tâche "courante" de la base de données.
         * @return bool True en cas de succés, False en cas d'échec.
         */
        public function delete(): bool {
            $sql = "DELETE FROM chrono WHERE chrono_id=:chrono_id";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);
                
                $query-> bindParam(":chrono_id", $this-> chrono_id, PDO::PARAM_INT);
    
                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception|Error $e) {
                return false;
            }
        }
    }