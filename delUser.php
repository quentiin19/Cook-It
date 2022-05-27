<?php
session_start();
require "functions.php";

//Vérification de l'utilisateur
$id = $_POST["id"];
if(!isConnected()){
	die("Il faut se connecter !!!");
}


//Suppression du user en bdd
$pdo = connectDB();
$queryPrepared = $pdo->prepare("DELETE FROM USER WHERE id=:id");
$queryPrepared->execute(["id"=>$id]);

//Si c'est le user actuellement connecté je le deco
if ($_SESSION['id'] == $id){
	header("Location: logout.php");
}


//redirection sur la home
header("Location: index.php");