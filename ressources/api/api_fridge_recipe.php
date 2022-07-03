<?php
session_start();
include '../../functions.php';

header("Content-type: application/json");


//récupération des variables
$id = $_GET['id'];
$dif = $_GET['dif'];



function returnRecipes($difficulty, $id){
    $found = 0;
    $id_recipes_found = array();
    $recipes_found = array();

    $pdo = connectDB();
    
    //récupération des ingrédients du frigo d'un user
    $query = $pdo->prepare("SELECT * FROM FRIDGE WHERE ID_USER = :id;");
    $query->execute(['id'=>$id]);
    $ingredients = $query->fetchAll();

    //récupération de toutes les recettes
    $query = $pdo->prepare("SELECT * FROM RECIPES;");
    $query->execute();
    $recipes = $query->fetchAll();

    //pour chaque recette,
    foreach ($recipes as $key => $recipe) {
        $query = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
        $query->execute(['id'=>$recipe['ID_RECIPE']]);
        $needs = $query->fetchAll();

        //on boucle sur tous les besoins de la recette
        foreach ($needs as $key => $need) {
            foreach ($ingredients as $key => $ingredient) {
                if ($ingredient['ID_INGREDIENT'] == $need['ID_INGREDIENT']) {
                    if ($ingredient['QUANTITY'] >= $need['QUANTITY']) {
                        //si les ingredients du frigo sont suffisant, on ajoute 1 à found
                        $found += 1;
                    }
                }
            }
        }
        //si le nombre d'ingrédients trouvés correspondent à la demande
        if ($found >= (count($needs) - $difficulty)) {
            //on ajoute la recette au recette faisable
            array_push($id_recipes_found, $recipe);
        }
        $found = 0;
    }

    //on récupère toutes les info de chaque recette valide
    foreach ($id_recipes_found as $id_recipe) {
        $query = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_RECIPE = :id;");
        $query->execute(["id"=>$id_recipe['ID_RECIPE']]);
        $temp = $query->fetch();

        
        array_push($recipes_found, $temp);
    }

    return json_encode($recipes_found);
}

echo returnRecipes($dif, $id);