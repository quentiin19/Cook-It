<?php
session_start();
require "../functions.php";
//une fois qu'on se co on met à jour la bdd de
if($_GET['id']==$_SESSION['id']){
    if($_GET['cle']== $_SESSION['cle']){
        $queryPrepared = $pdo->prepare("UPDATE USER set role = 1 WHERE ID=:id ; ");
        $queryPrepared->execute(["id"=>$_SESSION['id']]);
    }
    else
        echo "votre lien n'est plus valide";
}


?>