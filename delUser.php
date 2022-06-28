<?php
session_start();
require "functions.php";

//Ordre des BDD où il faut delete les données : 
/*
- MESSAGE -> Supprimer tous les messages qui implique le user
- SUBSCRIPTION -> supprimer tous les abonnements du user
- FRIDGE -> supprimer tous les ingrédients dans le frigo du user
- RECIPES_SAVED -> supprimer toutes les recettes sauvegardées par le user
- PICTURES -> supprimer toutes les images dans qui appartiennent à des recettes créé par le user
- NEED -> supprimer tous les besions des recettes créé par le user
- VOTES -> supprimer tous les votes du user
- RECIPES -> supprimer toutes les recettes créé par le user
- LOGS -> supprimer tous les logs du user
- USER -> enfin supprimer le user dans la table USER


*/



//Vérification de l'utilisateur
if(isAdmin() || $_GET['id'] == isConnected()){
	//connexion à la base de données
	$pdo = connectDB();

	$id = $_GET['id'];

	//suppression des messages
	$queryPrepared = $pdo->prepare("DELETE FROM MESSAGE WHERE ID_SENDER=:id OR ID_RECEIVER=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des abonnements
	$queryPrepared = $pdo->prepare("DELETE FROM SUBSCRIPTION WHERE ID_SUBSCRIPTION=:id OR ID_SUBSCRIBER=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//suppression du frigo
	$queryPrepared = $pdo->prepare("DELETE FROM FRIDGE WHERE ID_USER=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des recettes que le user à sauvegardé
	$queryPrepared = $pdo->prepare("DELETE FROM RECIPES_SAVED WHERE ID_USER=:id;");
	$queryPrepared->execute(["id"=>$id]);

	//suppression des recettes que le user à créé et que d'autres ont sauvegardé
	$queryPrepared = $pdo->prepare("DELETE FROM RECIPES_SAVED WHERE ID_RECIPE IN (SELECT * FROM RECIPES WHERE ID_CREATOR=:id);");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des images dans les recettes que le user à créé
	$queryPrepared = $pdo->prepare("DELETE FROM PICTURE WHERE ID_RECIPE IN (SELECT * FROM RECIPES WHERE ID_CREATOR=:id);");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des besoin des recettes créé par le user
	$queryPrepared = $pdo->prepare("DELETE FROM NEED WHERE ID_RECIPE IN (SELECT * FROM RECIPES WHERE ID_CREATOR=:id);");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des votes du user
	$queryPrepared = $pdo->prepare("DELETE FROM VOTES WHERE ID_USER=:id;");
	$queryPrepared->execute(["id"=>$id]);

	//suppression des votes sur les recettes créé par le user
	$queryPrepared = $pdo->prepare("DELETE FROM VOTES WHERE ID_RECIPE IN (SELECT * FROM RECIPES WHERE ID_CREATOR=:id);");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des recettes créées par le user
	$queryPrepared = $pdo->prepare("DELETE FROM RECIPES WHERE ID_CREATOR=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//suppression des logs du user
	$queryPrepared = $pdo->prepare("DELETE FROM LOGS WHERE ID=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//suppression du user lui-même
	$queryPrepared = $pdo->prepare("DELETE FROM USER WHERE ID=:id;");
	$queryPrepared->execute(["id"=>$id]);



	//redirection sur la home
	header("Location: index.php");

}else{
	die("Vous ne pouvez pas supprimer ce compte.");
}

