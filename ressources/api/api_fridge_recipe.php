<?php
session_start();
include '../../functions.php';

header("Content-type: application/json");


$pdo = connectDB();
$id = $_GET['id'];
$dif = $_GET['dif'];
//$token = $_GET['token'];


function returnRecipes($difficulty, $id){
    $query = $pdo->prepare("SELECT ID_INGREDIENT FROM FRIDGE WHERE ID_USER = :id;");
    $query->execute(['id'=>$id]);
    $ingredients = $query->fetchAll();


    $query = $pdo->prepare("SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE IN (SELECT ID_RECIPE FROM RECIPES);");
    $query->execute(['id'=>$id]);
    $ingredients = $query->fetchAll();

    echo '<pre>';
    print_r($ingredients);
    echo '</pre>';

}


// $query = $pdo->prepare("SELECT TOKEN FROM USER WHERE ID = :id;");
// $query->execute(['id'=> $id]);
// $tokenbdd = $query->fetch();



// if ($tokenbdd[0] == $token) {
//     echo returnRecipes($dif, $id);
// }
echo returnRecipes($dif, $id);