<?php 

    require_once "core/model/bdd.class.php";
    require_once "core/model/metier.class.php";
    require_once "core/model/tache.class.php";
    require_once "core/model/user.php";
    // require_once "core/model/sphere.class.php";
    require_once "core/model/event.class.php";

    $user = User::findByiD($_SESSION["user-id"]);
    $userMetier = Metier::findUserMetier($user->id);
    $userEvent = Event::findUserEvent($user->id);
    $userTache = Tache::findUserTask($user->id);

    $id = $user->id;

    $sql = "SELECT * FROM evenements WHERE id_utilisateur=:id_utilisateur ORDER BY id_metier ASC;";
    $sql2 = "SELECT * FROM metiers WHERE id_utilisateur=:id_utilisateur ORDER BY id_metier ASC;";
    $sql3 = "SELECT * FROM taches WHERE id_utilisateur=:id_utilisateur ORDER BY tache_id ASC;";
    // $sql4 = "SELECT * FROM recette_depense INNER JOIN evenements on recette_depense.id_recette = evenements.evenement_id WHERE id_utilisateur = :id_utilisateur;";
    $sql4 = "SELECT label FROM spheres;";
    $sql5 = "SELECT * FROM recette_depense WHERE id_utilisateur = :id_utilisateur;";
    $sql6 = "SELECT COUNT(id_sphere) AS pro FROM metiers WHERE id_utilisateur = :id_utilisateur AND id_sphere = 1;";
    $sql7 = "SELECT COUNT(id_sphere) AS perso FROM metiers WHERE id_utilisateur = :id_utilisateur AND id_sphere = 2;";


    $db_obj = new Database();
    $db_connection = $db_obj->dbConnection();

    $statement = $db_connection->prepare($sql);
    $statement->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement->execute();

    $statement2 = $db_connection->prepare($sql2);
    $statement2->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement2->execute();

    $statement3 = $db_connection->prepare($sql3);
    $statement3->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement3->execute();

    $statement4 = $db_connection->prepare($sql4);
    $statement4->execute();

    $statement5 = $db_connection->prepare($sql5);
    $statement5->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement5->execute();

    $statement6 = $db_connection->prepare($sql6);
    $statement6->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement6->execute();

    $statement7 = $db_connection->prepare($sql7);
    $statement7->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
    $statement7->execute();

    $results = $statement->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    $results2 = $statement2->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    $results3 = $statement3->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    $results4 = $statement4->fetch();
    $results5 = $statement5->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    $results6 = $statement6->fetch();
    $results7 = $statement7->fetch();
  
    $json = json_encode(['evenements'=>$results], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('events2.json', $json);

    $json2 = json_encode(['metiers'=>$results2], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('metiers.json', $json2);

    $json3 = json_encode(['taches'=>$results3], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('taches.json', $json3);

    // $json4 = json_encode(['spheres'=>$results4], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // file_put_contents('spheres.json', $json4);

    $json5 = json_encode(['recettesDepenses'=>$results5], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('recettes_depenses.json', $json5);

    // $json6 = json_encode(['sphereAVG'=>$results6], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // file_put_contents('spheresAvg.json', $json6);

    // $json6 = '{
    //             "spheres": [
    //                 {"perso":'.$results6["pro"].'},
    //                 {"label": '.$results4["label"].'}
    //                 ';

    // $json6 .= '{"pro":'.$results7["perso"].'}
    // ]}';

    $json6 = '{"spheres":[{"id_sphere": 1, "label": "Pro", "total":' .$results6["pro"] . '},'; 
    $json6 .= '{"id_sphere": 2, "label": "Perso", "total":' .$results7["perso"] . '}]}';

    file_put_contents('sphere.json', $json6);





    
    
