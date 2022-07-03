<?php
session_start();
include '../../functions.php';

header("Content-type: application/json");



$id = $_GET['id'];
$dif = $_GET['dif'];



function returnRecipes($difficulty, $id){
    $missingIngr = 0;
    $found = 0;
    $id_recipes_found = array();
    $recipes_found = array();

    $pdo = connectDB();
    $query = $pdo->prepare("SELECT * FROM FRIDGE WHERE ID_USER = :id;");
    $query->execute(['id'=>$id]);
    $ingredients = $query->fetchAll();





    $query = $pdo->prepare("SELECT ID_RECIPE FROM RECIPES;");
    $query->execute();
    $recipes = $query->fetchAll();


    foreach ($recipes as $key => $recipe) {
        $query = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
        $query->execute(['id'=>$recipe['ID_RECIPE']]);
        $needs = $query->fetchAll();

        foreach ($needs as $key => $need) {
            foreach ($ingredients as $key => $ingredient) {
                if ($ingredient['ID_INGREDIENT'] == $need['ID_INGREDIENT']) {
                    if ($ingredient['QUANTITY'] >= $need['QUANTITY']) {
                        $found += 1;
                    }
                }
            }
        }

        if ($found >= (count($needs) - $difficulty)) {
            array_push($id_recipes_found, $recipe);
        }
    }

    foreach ($id_recipes_found as $id_recipe) {
        $query = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_RECIPE = :id;");
        $query->execute(["id"=>$id_recipe]);
        $temp = $query->fetch();

        array_push($id_recipes_found, $temp);
    }
    return json_encode($recipes_found);
}

echo returnRecipes($dif, $id);