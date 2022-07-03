<?php
session_start();
require "functions.php";

//récupération de l'id de la recette
$id_recipe = $_GET['id_recipe'];


if (isConnected()) {
    //récupération de la recette
    $id_user = isConnected();

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT COUNT(ID_USER) FROM RECIPES_SAVED WHERE ID_RECIPE = :id_recipe AND ID_USER = :id_user;");
    $queryPrepared->execute(["id_recipe" => $id_recipe, "id_user" => $id_user]);
    $result = $queryPrepared->fetch();

    //si la recette est déjà enregistrée on la "désenregistre"
    if ($result[0] == 1) {
        $queryPrepared = $pdo->prepare("DELETE FROM RECIPES_SAVED WHERE ID_RECIPE = :id_recipe AND ID_USER = :id_user;");
        $queryPrepared->execute(["id_recipe" => $id_recipe, "id_user" => $id_user]);
    
    //sinon on l'enregistre
    } else {
        $queryPrepared = $pdo->prepare("INSERT INTO RECIPES_SAVED VALUES (:id_user, :id_recipe, NOW());");
        $queryPrepared->execute(["id_recipe" => $id_recipe, "id_user" => $id_user]);
    }
}

header("Location: recette.php?id=" . $id_recipe);
