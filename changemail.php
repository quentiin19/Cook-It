<?php
session_start();
require "functions.php";
require './test/TestConfirmMail/inscription.php';
?>
<?php
$email = $_POST['emailold'];
if(isConnected()){
    if(($_POST['emailold'])==($_SESSION['email'])){
        $pdo= ConnectDB();
        
        $emailold = $_POST['emailold'];
        //on va reccuperer les données en bdd du user pour voir s'il exise bien
        $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE MAIL = :email;");
    	$queryPrepared->execute(["email"=>$emailold]);
    	$result = $queryPrepared->fetch();
    	
    	//si on retourne quelque chose on change le mail
    	if(isset($result)){
    	$cle = rand(1000000,9000000);
    	
    	$_SESSION['id']= $result['ID'];
    	$_SESSION['cle']= $cle;
    	
    	$emailnew = $_POST['emailnew'];
    	$from = 'support-cookit@cookit.com';
    	$name = "Cookit-supportTeam";
    	$subj = 'Mail de confirmation';
        $msg = '<a href=https://cookit.ovh/test/TestConfirmMail/verifcm.php?id='.$_SESSION['id'].'&cle='.$cle.'&mail='.$emailnew.'>Confirmer</a><h1>Cliquez sur le lien de confirmation juste au dessus</h1>';
    	smtpmailer($emailnew,$from, $name ,$subj, $msg);
    	header("Location: https://cookit.ovh/index.php");
    	unset($_SESSION['email']);
    	unset($_SESSION['token']);
        }		
	
    }else{
        echo' Veillez saisir la bonne adresse email associé à votre compte';
    }
}else{
    echo'Veillez vous connecter';
}