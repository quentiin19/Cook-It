<?php
session_start();
require "../../functions.php";

print_r($_SESSION);
print_r($_GET);

if($_GET['id'] == $_SESSION['id']){
    if($_GET['cle'] == $_SESSION['cle']){
        $pdo = connectDB();
        
        $queryPrepared = $pdo->prepare("UPDATE USER SET MAIL = :mail where USER.ID = :id");
	    $queryPrepared->execute(["id"=>$_SESSION['id'], "mail" => $_POST['emailnew']]);
        echo "Vous avez bien validé votre mail, cliquez sur le lien ci dessous pour vous connecter";
        echo "<brs><a href=http://51.255.172.36/login.php>Se Connecter</a>";
    }else{
        echo "votre lien n'est plus valide";
    }
}else{
    echo "votre lien n'est plus valide";
}


?>