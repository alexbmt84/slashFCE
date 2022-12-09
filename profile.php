<?php
session_start();
require_once "core/model/bdd.class.php";
require_once "core/model/user.php";
require_once "footer.php"; 

if(!isset($_SESSION['user'])){ // si on est pas connecté, on redirige à l'index
  header('Location:index.php');
}

$user = User::findByiD($_SESSION["user-id"]); // methode findById de la classe User avec en paramètres l'id de l'utilidateur (de la session en cours)
$test_orig_image = "https://www.nicepng.com/png/detail/73-730154_open-default-profile-picture-png.png"; // image par defaut
$my_deafult_image = "https://www.nicepng.com/png/detail/73-730154_open-default-profile-picture-png.png"; // image par defaut
$checkImg = User::check_image_exists($test_orig_image, $my_deafult_image = 'default.png'); // méthode image par défaut de la classe User

// Change profile picture

if(!empty($_FILES) && isset($_FILES['avatar'])) { // si $_FILES n'est pas vide et que le "name" avatar existe
    $tailleMax = 2097152; // initialisation de la taille max autorisée
    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png'); // les formats d'images valides
    $id = $_SESSION['user-id']; // initialisation de la variable id dans laquelle on stocke l'id de l'utilisateur connecté

    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK AND $_FILES['avatar']['size'] <= $tailleMax) { // Si avatar ne retourne pas d'erreur et si sa taille est inferieure ou égale à $tailleMax


        $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1)); // Initialise la variable qui servira à ajouter l'extension
        if (in_array($extensionUpload, $extensionsValides)) {
            $chemin = "membres/avatars/".$_SESSION['user-id'].".".$extensionUpload; // preparation du chemin de stockage de l'image en fonction de l'id de l'utilisateur et de $extensionUpload
            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin); // // on déplace les fichiers uploadés dans $chemin et on stocke le tout dans une variable $resultat
            if($resultat) { // si on obtient un resultat

                // on se connecte à la bdd
                $db_obj = new Database();
                $db_connection = $db_obj->dbConnection();

                $updateAvatar = $db_connection->prepare('UPDATE utilisateurs SET avatar = :avatar WHERE id = :id'); // requete sql update avatar en fonction de l'id de l'utilisateur
                $updateAvatar->execute(array( // execution de la requete sql et creation d'un tableau
                    "avatar" => $_SESSION['user-id'].".".$extensionUpload, // equivalent bindParam (lie)
                    "id" => $_SESSION['user-id'] //  // equivalent bindParam (lie)
                ));
            header('Location: profile.php?id='.$id); // on redirige à la page profile de l'utilisateur connecté 
            } else {
                echo "<p class='err'>Erreur durant l'importation de la photo de profil.";
            }
        } else {
            echo "<p class='red'>Pas le bon format d'image.</p>";
        }
    } else {
        echo "<p class='err'>Votre photo de profil n'est pas valide.</p>";
    }
}

// Changement de pseudo
if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']) and $_POST['newpseudo'] != $user->pseudo) { // si 'newpseudo' existe, qu'il n'est pas vide et qu'il est différent du pseudo de l'utilisateur...

    $pseudo = $user->pseudo;
    $id = $_SESSION['user-id'];
    $newpseudo = htmlspecialchars($_POST['newpseudo']); // Convertit des caractères speciaux en entité
    $pseudolength = strlen($newpseudo); // longueur de $newpseudo stockée dans $pseudoLenght

    if ($pseudolength <= 255) { // si $pseudolenght est inferieur ou egal à 255 caracteres

        //connexion à la base de données
        $db_obj = new Database();
        $db_connection = $db_obj->dbConnection();

        $reqpseudo = $db_connection->prepare("SELECT * FROM utilisateurs WHERE pseudo = ? AND id != ?"); // preparation de la requete sql
        // $reqpseudo->execute(array($pseudo));
        $reqpseudo->execute(array($pseudo, $id)); // execution de la requete
        $pseudoexist = $reqpseudo->rowCount(); // compte les lignes obtenues et stocke le tout dans $pseudoexist

        if ($pseudoexist == 0) { // verifie que le pseudo n'est pas utilisé

            // connexion à la bdd
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $insertpseudo = $db_connection->prepare('UPDATE utilisateurs SET pseudo = ? WHERE id = ?'); // requete sql pour update le pseudo de l'utilisateur
            $insertpseudo->execute(array($newpseudo, $id)); // execution de la requete
            header('Location: profile.php?id=' . $id); // on redirige sur la page profile si tout est bon 
        } else {
            $msg = "Ce pseudo est déjà pris.";
        }
    } else {
        $msg = "Votre pseudo ne doit pas dépasser 255 caractères.";
    }
}


// Changement d'email 
if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $user->email) {
    $email = $user->email;
    $id = $_SESSION['user-id'];
    $newmail = htmlspecialchars($_POST['newmail']);
    $newmail = strtolower($newmail);

    if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
        $db_obj = new Database();
        $db_connection = $db_obj->dbConnection();

        $reqmail = $db_connection->prepare("SELECT * FROM utilisateurs WHERE email = ? AND id!= ?");
        $reqmail->execute(array($email, $id));
        $mailexist = $reqmail->rowCount();

        if ($mailexist == 0) {
            $db_obj = new Database();
            $db_connection = $db_obj->dbConnection();

            $insertmail = $db_connection->prepare('UPDATE utilisateurs SET email = ? WHERE id = ?');
            $insertmail->execute(array($newmail, $id));
            header('Location: profile.php?id=' . $id);
        } else {
            $msg = "Cette adresse mail est déjà utilisée !";
        }
    } else {
        $msg = "Votre email n'est pas valide.";
    }
}


// Change password
if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
    $password = $user->password;
    $id = $_SESSION['user-id'];
    $cost = ['cost' => 12];
    $mdp1 = ($_POST['newmdp1']);
    $mdp2 = ($_POST['newmdp2']);

    if($mdp1 == $mdp2) {
        $mdp1 = password_hash($mdp1, PASSWORD_BCRYPT, $cost);

        $db_obj = new Database();
        $db_connection = $db_obj->dbConnection();

        $insertmdp = $db_connection->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
        $insertmdp->execute(array($mdp1, $id));
        header('Location: profile.php?id='.$id);
    } else {
       echo "<p>Les mots de passe doivent être identiques.</p>" ;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire évènements</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/doughnut.css">
  <script src="js/photo.js" defer></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js' defer></script><script  src="./script.js" defer></script>
</head>

<body>
<h2><span class="hello">Bienvenue, </span><br><?= $user->pseudo; ?> !</h2>
<h1>Profil</h1>
<form class="formEdit" action="" method="POST" enctype="multipart/form-data">  
 
<?php 
$image = $user->avatar;
if (empty($image)) { ?>
<div class="profile-pic">
        <label for="file" class="-label">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change Image</span>
        </label>
        <input id="file" type="file" name="avatar" onchange="loadFile(event);"/>
        <img src="<?php echo $checkImg; ?>" alt="My Test Image" id="output" width="150px" />
    </div>
<?php
} else {
?>

    <div class="profile-pic">
        <label for="file" class="-label">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change Image</span>
        </label>
        <input id="file" type="file" name="avatar" onchange="loadFile(event);"/>
        <img src="membres/avatars/<?= $user->avatar; ?>" id="output" width="150px" />
    </div> <?php } ?>

        <input class="text-input1" type="text" name="newpseudo" placeholder="<?= $user->pseudo;?>" value="">
        <input class="text-input3" type="email" name="newmail" placeholder="<?= $user->email;?>" value="">
        <input class="text-input3" type="password" name="newmdp1" placeholder="Password">
        <input class="text-input3" type="password" name="newmdp2" placeholder="Confirm your password">
        <input id="btn2" class="inputSubmit" type="submit" value="Update">  
    </form>
