<?php
session_start();
require "functions.php";


$id_recipe = $_GET['id_recipe'];

if(isConnected()){
    $id_user = isConnected();
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT COUNT(ID_USER) FROM RECIPES_SAVED WHERE ID_RECIPE = :id_recipe AND ID_USER = :id_user;");
    $queryPrepared->execute(["id_recipe"=>$id_recipe, "id_user"=>$id_user]);
    $result = $queryPrepared->fetch();

    print_r($result);

    if ($result == 1) {
        $queryPrepared = $pdo->prepare("DELETE FROM RECIPES_SAVED WHERE ID_RECIPE = :id_recipe AND ID_USER = :id_user;");
        $queryPrepared->execute(["id_recipe"=>$id_recipe, "id_user"=>$id_user]);
    }else{
        $queryPrepared = $pdo->prepare("INSERT INTO RECIPES_SAVED VALUES (:id_user, :id_recipe, CURRENT_TIMESTAMP);");
        $queryPrepared->execute(["id_recipe"=>$id_recipe, "id_user"=>$id_user]);
    }
}

header("Location: recette.php?id=".$id_recipe);