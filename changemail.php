<?php
session_start();
require "functions.php";
?>
<?php
$pdo= ConnectDB();

if(isConnected()){
    if(($_POST['emailold'])==($_SESSION['email'])){
        $queryPrepared = $pdo->prepare("UPDATE USER SET MAIL = :mail where USER.ID = :id");
	    $queryPrepared->execute(["id"=>$_SESSION['id'], "mail" => $_POST['emailnew']]);

    //repasser le statut à 0
		$queryPrepared = $pdo->prepare("UPDATE USER SET role = 0 where USER.ID = :id");
	    $queryPrepared->execute(["id"=>$_SESSION['id']]);					
	
    }else{
        echo' Veillez saisir la bonne adresse email associé à votre compte';
    }
}else{
    echo'Veillez vous connecter';
}