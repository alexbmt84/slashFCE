<?php
    require_once "core/model/user.php";
    if(!empty($_POST)) {
        if (isset($_POST["userDelete"]) && $_POST["userDelete"] != "" && is_numeric($_POST["userDelete"])) {
            $user = User::findById($_POST["userDelete"] );
            if (isset($_POST["confirm"])) {
                $user-> delete();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des comptes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/gestion.css">
</head>
<body>
    <?php
    if (isset($_POST["userDelete"]) && $_POST["userDelete"] != "" && is_numeric($_POST["userDelete"])):?>
    <?php if (!isset($_POST["confirm"])) : ?>

        <div id="confirmation">
            <p>Confimez vous la suppression de <?= $user-> pseudo; ?></p>
            <form action="" method="post">
                <input type="hidden" name="userDelete" value="<?= $user-> id; ?>">
                <input type="hidden" name="confirm" value="1">
                <button id="btn-trash" >Confirmer</button>
            </form>
            <form id="annuler" action="" method="post">
            <button id="btn-annuler" >Annuler</button>
            </form>
        </div>
    <?php endif; ?>
    <?php endif; ?>

    <h1>Gestion des comptes</h1>
    <div class="container">
        <table>
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Dernière connexion</th>
                <th>Supprimer</th>
            </tr>
        <?php  
        $listUsers = User::findAll();
        
        foreach($listUsers as $ligne):
            ?>
            <tr>
                <td><?= $ligne->pseudo;?></td>

                <td><?= $ligne->email; ?></td>
                <td>Le <?= $ligne->dateLogin-> format("d/m/Y"); ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="userDelete" value="<?= $ligne->id; ?>">
                        <button><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </td>
            </tr>
            
<?php endforeach ?>

        </table>
    </div>
<?php
  include "footer.php";
?>
