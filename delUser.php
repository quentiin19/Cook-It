<?php
session_start();
require "functions.php";

//Vérification de l'utilisateur
// $id = $_GET["id"];
if(!isConnected()){
	die("Il faut se connecter !!!");
}


//Suppression du user en bdd
$pdo = connectDB();
$queryPrepared = $pdo->prepare("DELETE FROM USER WHERE TOKEN=:token");
$queryPrepared->execute(["token"=>$_SESSION['token']]);

//Si c'est le user actuellement connecté je le deco
if ($_SESSION['id'] == $id){
	header("Location: logout.php");
}


//redirection sur la home
header("Location: index.php");