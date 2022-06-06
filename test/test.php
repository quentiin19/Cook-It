<?php 


require "../functions.php";


$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
$queryPrepared->execute();
$results = $queryPrepared->fetch();


print_r($results);
?>