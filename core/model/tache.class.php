<?php

require_once 'bdd.class.php';
require_once 'etat.class.php';

class Tache {
    private int $tache_id;
    private string $label;
    private DateTime $dateDebut;
    private array $chrono;
    private ?string $image;
    private int $etat;
    private int $id_utilisateur;
    private int $evenement_id;

    
    public function __construct(int $tache_id = 0, string $label = "", $dateDebut = "", string $image = "", int $etat = 0, int $id_utilisateur=0, int $evenement_id = 0) {

        $this->tache_id = $tache_id;
        $this->label = $label;
        $this->image = $image;
        $this->etat = Etat::ATTENTE;
        $this->id_utilisateur = $id_utilisateur;
        $this->evenement_id = $evenement_id;
        $this->dateDebut = new Datetime();


        try {
            $this-> dateDebut = new DateTime($dateDebut);     
        } catch (Exception|Error $e) {
            $this-> dateDebut = new DateTime();
        }

        $this-> chrono = array();

    }

    public function __set($property, $value) {
        if ($property == "date_debut")
                $this-> dateDebut = new DateTime($value);
            else
                $this-> $property = $value;
    }

    public function __get($property) {
        if ($property == "date_debut")
            return $this-> dateDebut-> format("Y-m-d");
        else
        return $this-> $property;
    }

        /**
         * start()
         * Lancement d'une tâche : création en base de données et état mis en ACTIF
         * Avec lancement d'un chrono (Timer)
         * @return bool booléen marquant le succès ou l'échec de l'enregistrement de la tâche dans la base de données.
         */
        public function start(): bool {
            $this-> etat = Etat::ACTIF;
            if ($this-> update()) {
                $chrono = new Chrono();
                $chrono-> tache_id = $this-> tache_id;

                if ($chrono-> start()) {
                    $this-> chrono[] = $chrono;

                    return true;
                }
            }

            return false;
        }

        /**
         * pause()
         * Arrêt du dernier chorno actif (Timer) : mise à jour en base de données en base de données et état mis en PAUSE
         * @return bool booléen marquant le succès ou l'échec de l'enregistrement de la tâche dans la base de données.
         */
        public function pause(): bool {
            $this-> etat = Etat::PAUSE;

            if ($this-> update()) {
                $this-> chrono[count($this-> chrono)-1]-> stop();

                return true;
            } else {
                return false;
            }
        }

        /**
         * stop()
         * Arrêt du dernier chorno actif (Timer) : mise à jour en base de données en base de données et état mis en STOP
         * @return bool booléen marquant le succès ou l'échec de l'enregistrement de la tâche dans la base de données.
         */
        public function stop(): bool {
            $this-> etat = Etat::STOP;

            if ($this-> update()) {
                if (count($this-> chrono) > 0) {
                    if ($this-> etat == Etat::ACTIF) {
                        $this-> chrono[count($this-> chrono)-1]-> stop();
                    }
                }

                return true;
            } else  return false;
        }

        /**
         * save()
         * Sauvegarde en base de données une nouvelle tâche avec etat mis à ATTENTE
         * @return bool True en cas de succès - False en cas d'échec
         */
        public function save(): bool {

            $sql = "INSERT INTO taches (label, image, id_utilisateur, evenement_id) VALUES (:label, :image, :id_utilisateur, :evenement_id );";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);

                $query-> bindParam(":label", $this-> label, PDO::PARAM_STR);
                $query-> bindParam(":image", $this-> image, PDO::PARAM_STR);
                $query-> bindParam(":id_utilisateur", $this-> id_utilisateur, PDO::PARAM_INT);
                $query-> bindParam(":evenement_id", $this-> evenement_id, PDO::PARAM_STR);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception|Error $e) {
                die($e-> getMessage());
                return false;
            }
        }

        /**
         * UPDATE()
         * Met à jour une tâche en base de données.
         * @return bool True en cas de succès - False en cas d'échec
         */
        public function update(): bool {
            $sql = "UPDATE taches SET label=:label, etat=:etat, WHERE tache_id=:tache_id;";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj-> dbConnection();

                $query = $db_connection-> prepare($sql);

                $query-> bindParam(":label", $this-> label, PDO::PARAM_STR);
                $query-> bindParam(":etat", $this-> etat, PDO::PARAM_INT);
                $query-> bindParam(":tache_id", $this-> tache_id, PDO::PARAM_INT);

                if ($query-> execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception|Error $e) {
                return false;
            }
        }
    /*****************************************************************  Find Task by id  *****************************************************************/

    /**
     * findTaskById permet de lister les tâches sockées en base de données
     * @param int $id l'identifiant de la tâche en BDD
     * @return Tache Tâche qui correspond à l'id passé en enregistrement
     */

    public static function findTaskById(int $tache_id): Tache
    {
        require_once "core/model/bdd.class.php";

        $sql = "SELECT * FROM taches WHERE tache_id = :tache_id";

        try {
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $requete = $db_connection->prepare($sql);
            $requete->bindParam(":tache_id", $tache_id, PDO::PARAM_INT);
            $requete->execute();

            $resultats = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE);

            return $resultats[0];
        } catch (PDOException $exc) {
            echo "<h1>Erreur</h1>";
            echo "<p> .$exc-> getMessage() . </p>";
            die();
        }
    }
        /**
         * static findAll()
         * Trouve toutes les tâches stockées en base de données.
         * @return [Tache] tableau contenant toutes les tâches ou tableau vide.
         */
        public static function findAll(): ?array {
            $sql = "SELECT * FROM taches ORDER BY tache_id ASC";

            try {
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $query = $db_connection->prepare($sql);

                if ($query-> execute()) {
                    $query-> setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Tache");
                    $results = $query-> fetchAll();

                    return $results;
                } else {
                    return null;
                }

            } catch (Exception|Error $e) {
                return null;
            }
        }

         /***************************************************************  FIND Event BY USER  ***********************************************************/

    public static function findUserTask(int $id_utilisateur) {

        $sql = "SELECT * FROM taches WHERE id_utilisateur=:id_utilisateur ORDER BY tache_id ASC;";
                
        try {
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $query = $db_connection-> prepare($sql);
            $query-> bindParam("id_utilisateur", $id_utilisateur, PDO::PARAM_INT);

            if ($query-> execute()) {
                $resultats = $query-> fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Tache"); 

                // var_dump($resultats);
                // die();
                return $resultats;
            } else {
                return array();
            }
        } catch (Exception | PDOException | Error $e ) {
            die($e-> getMessage());
            return array();
        }
    }
         /***************************************************************  FIND ITEM BY JOINT  ***********************************************************/

    public static function findItemByJoint(int $id_utilisateur) {
        require_once "core/model/bdd.class.php";

        $sql = "SELECT metiers.couleur, metiers.icone, taches.label, taches.date_debut, taches.image, taches.etat FROM metiers
        INNER JOIN evenements on metiers.id_metier=evenements.id_metier 
        INNER JOIN taches on evenements.evenement_id=taches.evenement_id 
        WHERE metiers.id_utilisateur=:id_utilisateur;";
                
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            try {
                $request = $db_connection->prepare($sql);
                $request-> bindParam(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
                $request->execute();

                $results = $request->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Tache");

                return $results;

            } catch (PDOException $exc) {
                echo "<h1>Erreur</h1>";
                echo "<p>" . $exc->getMessage() . "</p>";
            }
    }


        /**
         * delete()
         * Supprime la tâche courante de la base de données après avoir supprimé tous ses timers associés.
         * @return bool True en cas de succès, False en cas d'échec.
         */
        public function delete(): bool {
            $continuer = true;

            // supprimer tous les Timers de la tâche
            foreach ($this-> chrono as $item) {
                if (!$item-> delete())
                    $continuer = false;
            }

            // Si succès de suppression des Timers associés:
            // supprimer la tâche
            if ($continuer) {
                $sql = "DELETE FROM taches WHERE tache_id=:tache_id";

                try {
                    $db_obj = new Database();
                    $db_connection = $db_obj->dbConnection();

                    $query = $db_connection->prepare($sql);

                    $query-> bindParam(":tache_id", $this-> tache_id, PDO::PARAM_INT);

                    if ($query-> execute()) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (Exception|Error $e) {
                    //die($e-> getMessage());
                    return false;
                }
            }

            return false;
        }

        /**
         * loadAllTimers()
         * Charge tous les timers associés à une tâche dans sa attribut (tableau) timers.
         */
        public function loadAllTimers(): void {
            require_once "chrono.php";
            // Charger toutes les tâches d'une catégorie
            $this-> chrono = Chrono::findByTache($this-> tache_id);  
        }

}
