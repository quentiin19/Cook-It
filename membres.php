<?php include "template/header.php";?> 

<?php

$pdo = connectDB();
$afficher_membres = $pdo->prepare("SELECT * FROM USER");
$afficher_membres -> execute();

foreach ($afficher_membres as $am){
    echo $am['PSEUDO'];
}

?>