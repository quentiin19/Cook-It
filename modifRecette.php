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
		
		
		
		
			
			
}		
?>