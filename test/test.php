<?php 


require "../functions.php";


$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID=2;");
$queryPrepared->execute();
$results = $queryPrepared->fetch();

print "<pre>";
print_r($results);
print "</pre>";
?>