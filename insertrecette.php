<?php

echo "testeurer";
// if(
// 	empty($_POST["recette"]) || 
// 	empty($_POST["recette_description"]) ||
// 	empty($_POST["fichier"])||
// 	count($_POST)!=3
// ){

// 	die("remplissez les champs requis");

// }else{
// 	echo "TEST";
// }


$recette = $_POST["recette"];
$recette_description = $_POST["recette_description"];
$fichier = $_POST["fichier"];

$queryPrepared = $pdo->prepare("INSERT INTO RECIPES (        
ID_CREATOR, 
TITLE,      
DESCRIPTION ) 
VALUES (:idcreator, :title, :recettedesc);");



$queryPrepared->execute([
						"idcreator"=>$_SESSION['ID'],
						"title"=>$recette,
						"recettedesc"=>$recette_description
]);


?>