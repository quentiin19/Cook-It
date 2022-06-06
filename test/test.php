<?php 


require "../functions.php";


$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
$queryPrepared->execute();
$results = $queryPrepared->fetchAll();

print "<pre>";
print_r($results);
print "</pre>";
?>