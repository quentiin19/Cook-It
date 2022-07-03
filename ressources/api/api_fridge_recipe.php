<?php
session_start();
include '../../functions.php';

//header("Content-type: application/json");



$id = $_GET['id'];
$dif = $_GET['dif'];

//$token = $_GET['token'];


function returnRecipes($difficulty, $id){
    $missingIngr = 0;
    $found = 0;
    $recipes_found = array();

    $pdo = connectDB();
    $query = $pdo->prepare("SELECT * FROM FRIDGE WHERE ID_USER = :id;");
    $query->execute(['id'=>$id]);
    $ingredients = $query->fetchAll();

    echo '<pre>';
    print_r($ingredients);
    echo '</pre>';



    $query = $pdo->prepare("SELECT ID_RECIPE FROM RECIPES;");
    $query->execute();
    $recipes = $query->fetchAll();


    foreach ($recipes as $key => $recipe) {
        $query = $pdo->prepare("SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id;");
        $query->execute(['id'=>$recipe['ID_RECIPE']]);
        $needs = $query->fetchAll();

        foreach ($needs as $key => $need) {
            foreach ($ingredients as $key => $ingredient) {
                if ($ingredient['ID'] == $need['ID_INGREDIENT']) {
                    if ($ingredient['QUANTITY'] >= $need['QUANTITY']) {
                        $found += 1;
                    }
                }
            }
        }

        if ($found >= (count($needs) - $dif)) {
            array_push($recipes_found, $recipe);
        }
    }
    echo json_encode($recipes_found);
}


// $query = $pdo->prepare("SELECT TOKEN FROM USER WHERE ID = :id;");
// $query->execute(['id'=> $id]);
// $tokenbdd = $query->fetch();



// if ($tokenbdd[0] == $token) {
//     echo returnRecipes($dif, $id);
// }
echo returnRecipes($dif, $id);