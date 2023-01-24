<?php 
    require_once '../model/config.php';

   if(!empty($_GET['u']) && !empty($_GET['token']) ){
       
    $u = htmlspecialchars(base64_decode($_GET['u']));
    $token = htmlspecialchars(base64_decode($_GET['token']));
       
    $check = $bdd->prepare('SELECT * FROM password_recover WHERE token_user = ? AND token = ?');
    $check->execute(array($u, $token));
    $row = $check->rowCount();
    $data = $check->fetch();
       
    if($row){
        
        $get = $bdd->prepare('SELECT token FROM utilisateurs WHERE token = ?');
        $get->execute(array($u));
        $data_u = $get->fetch();
        
        if(hash_equals($data_u['token'], $u)){
            header('Location: password_change.php?u='.base64_encode($u));
            die();
        }else{
            echo "Erreur : token non valide";
        }
    }else{
        echo "Erreur : compte inexistant";
    }
}else {
    echo "Lien non valide";
}