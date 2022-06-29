<?php

session_start();
require "functions.php";

$id_recipe = $_GET['id'];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id"=> $id_recipe]);
$recipe = $queryPrepared->fetch();

print_r($recipe);

if(isAdmin() || isConnected() == $recipe['ID_CREATOR']){

    //suppression de la table besion 
    $queryPrepared = $pdo->prepare("DELETE FROM NEED WHERE ID_RECIPE = :id;");
    $queryPrepared->execute(["id"=> $id_recipe]);


    //suppression des recettes sauvegardées
    $queryPrepared = $pdo->prepare("DELETE FROM RECIPES_SAVED WHERE ID_RECIPE = :id;");
    $queryPrepared->execute(["id"=> $id_recipe]);

    //suppression de la recette
    $queryPrepared = $pdo->prepare("DELETE FROM RECIPES WHERE ID_RECIPE = :id;");
    $queryPrepared->execute(["id"=> $id_recipe]);


    //update des logs
    updateLogs($recipe['ID_CREATOR'], 'la recette "'.$recipe['TITLE'].'" a été supprimée');

    
}

header("Location: index.php");