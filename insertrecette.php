<?php
require 'template/header.php';
// echo "testeurer";
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

$pdo = connectDB();
$queryPrepared = $pdo->prepare("INSERT INTO RECIPES (        
ID_CREATOR, 
TITLE,      
DESCRIPTION ) 
VALUES (:idcreator, :title, :recettedesc);");



$queryPrepared->execute([
						"idcreator"=>$_SESSION['id'],
						"title"=>$recette,
						"recettedesc"=>$recette_description
]);
header("Location:recette.php");

$queryPrepared = $pdo->prepare("SELECT ID FROM RECIPES WHERE ID_CREATOR=:id AND TITLE=:title");
$queryPrepared->execute(["id"=>$_SESSION['id'], "title"=>$recette]);
$result = $queryPrepared->fetch();

for ($i = 0; $i<5; $i++){

    if($_POST['checkbox'.$i]){
        $quantity = $_POST["quantity".$i];
        $queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
        $queryPrepared->execute(["quantity"=> $_POST["quantity"],
                                "id_recipes"=>$result['ID'], "id_ingr"=>$i ]);
    }
}
?>