<?php include "template/header.php";?>
<?php
if (isConnected() == $_SESSION['id']) {
		$pdo = connectDB();
		
		
		$queryPrepared = $pdo->prepare("SELECT *  FROM RECIPES WHERE ID_CREATOR = :id  AND ID_RECIPE = :idr");
		$queryPrepared ->execute(["id" => $_SESSION["id"], "idr" => $_GET["id"]]);
		$resultR = $queryPrepared->fetch();
		
		$queryPrepared = $pdo->prepare("SELECT *  FROM NEED WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["id" => $_GET["id"]]);
		$resultN = $queryPrepared->fetchAll();
		
		$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
		$queryPrepared->execute(["id"=>$_GET['id']]);
		$ingredients = $queryPrepared->fetchAll();
		
		echo '<pre>';
		print_r($resultN);
		echo'</pre>';
		echo '<pre>';
		print_r($ingredient);
		echo'</pre>';
		
		
			
			
}		
?>