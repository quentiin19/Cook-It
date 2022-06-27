<?php include "template/header.php";?> 

<?php
$afficher_membres = $pdo->prepare("SELECT * FROM USER");
$afficher_membres -> execute();

foreach ($afficher_membres as $am){
    echo'$am['pseudo']'';
}

?>