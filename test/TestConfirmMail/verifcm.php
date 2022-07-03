<?php
session_start();
require "../../functions.php";

print_r($_SESSION);
print_r($_GET);

if($_GET['id'] == $_SESSION['id']){
    if($_GET['cle'] == $_SESSION['cle']){
        $pdo = connectDB();
        
        $queryPrepared = $pdo->prepare("UPDATE USER SET MAIL = :mail where ID = :id");
	    $queryPrepared->execute(["mail"=> $_GET['mail'], "id"=>$_SESSION['id']]);
	    header("Location: https://cookit.ovh/login.php");
        echo "Vous avez bien validé votre mail, cliquez sur le lien ci dessous pour vous connecter";
        echo "<brs><a href=http://cookit.ovh/login.php>Se Connecter</a>";
    }else{
        echo "votre lien n'est plus valide";
    }
}else{
    echo "votre lien n'est plus valide";
}


?>