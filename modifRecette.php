<?php 
session_start();
include "./functions.php";?>
<?php

echo '<pre>';
print_r($_SESSION);
echo'</pre>';
echo '<pre>';
print_r($_POST);
echo'</pre>';

if (isConnected() == $_SESSION['id'] || isAdmin()) {
		$pdo = connectDB();
		
		
		$queryPrepared = $pdo->prepare("SELECT *  FROM RECIPES WHERE ID_CREATOR = :id  AND ID_RECIPE = :idr");
		$queryPrepared ->execute(["id" => $_SESSION["id"], "idr" => $_POST["idrecipe"]]);
		$resultR = $queryPrepared->fetch();
		
		$queryPrepared = $pdo->prepare("SELECT *  FROM NEED WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["id" => $_POST["idrecipe"]]);
		$resultN = $queryPrepared->fetchAll();
		
		$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
		$queryPrepared->execute(["id"=>$_POST["idrecipe"]]);
		$ingredients = $queryPrepared->fetchAll();
		
		echo '<pre>';
		print_r($resultN);
		echo'</pre>';
		echo '<pre>';
		print_r($ingredients);
		echo'</pre>';
		
		//on supprime tout les inredients pour pouvoir le mettre a jour après
		$queryPrepared = $pdo->prepare("DELETE FROM NEED WHERE ID_RECIPE = :id");
		$queryPrepared->execute(["id"=>$_POST["idrecipe"]]);
		
		//on rentre le titre
		$queryPrepared = $pdo->prepare("UPDATE RECIPES set TITLE = :title WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["title"=>$_POST["title"],"id" => $_POST["idrecipe"]]);
		
		//on rentre la description
		$queryPrepared = $pdo->prepare("UPDATE RECIPES set DESCRIPTION = :desc WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["desc"=>$_POST["recette_description"],"id" => $_POST["idrecipe"]]);
		
		for ($i = 1; $i<6; $i++){
			if(isset($_POST['checkbox'.$i])){
				$quantity = $_POST["quantity".$i];
				$queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
				$queryPrepared->execute(["quantity"=>$quantity, "id_ingr"=>$i ,"id_recipe"=>$_POST["idrecipe"]]);
			}
		}
		
		// header("Location: https://cookit.ovh/recette.php?id=".$_POST["idrecipe"]);
		
			
			
}		
?>