<?php 


require "../functions.php";


$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
$queryPrepared->execute();
$results = $queryPrepared->fetch();

foreach ($results as $key => $ingredient) {
    
}

print_r($results);
?>