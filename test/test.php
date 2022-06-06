<?php 


require "../functions.php";


$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
$queryPrepared->execute();
$results = $queryPrepared->fetch();

foreach ($ingredients as $key => $ingredient) {
    
}
?>