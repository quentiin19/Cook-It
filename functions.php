<?php
require "config.inc.php";

function connectDB(){
	//création d'une nouvelle connexion à notre bdd
	try{
				
		$pdo = new PDO( "mysql:host=localhost;dbname=ProjAnn;port=3306","chef" ,"QOY@BDD" );

    	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	}catch(Exception $e){
		die("Erreur SQL ".$e->getMessage());
	}


	return $pdo;
}

/*
	$token = createToken();
	updateToken($results["id"], $token);
*/

function createToken(){
	$token = sha1(md5(rand(0,100)."gdgfm432").uniqid());
	return $token;
}


function updateToken($userId, $token){

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("UPDATE USER SET TOKEN=:token WHERE ID=:id");
	$queryPrepared->execute(["token"=>$token, "id"=>$userId]);

}


function isConnected(){

	if(!isset($_SESSION["email"]) || !isset($_SESSION["token"])){
		return false;
	}

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT ID FROM USER WHERE MAIL=:email AND TOKEN=:token");	
	$queryPrepared->execute(["email"=>$_SESSION["email"], "token"=>$_SESSION["token"]]);

	return $queryPrepared->fetch();

}

function isAdmin() {

	if(!isset($_SESSION["email"]) || !isset($_SESSION["token"])){
		return false;
	}
	
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT role FROM USER WHERE MAIL=:email AND TOKEN=:token");
	$queryPrepared->execute(["email"=>$_SESSION["email"], "token"=>$_SESSION["token"]]);
	$resultat = $queryPrepared->fetch();
	if ($resultat['role'] == 2){
		return True;
	}
	
}

function updateLogs($id){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("INSERT INTO LOGS (ID, DATE_LOGIN) VALUES (:id , GETDATE());");
	$queryPrepared->execute(["id"=>$id]);
}


?>


