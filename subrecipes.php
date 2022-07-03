<?php
include "template/header.php";

?>
<div class='text-center'>
    <h1>Mon flux d'abonnement</h1>
</div>
<?php


$pdo = connectDB();

//récupération des id des abonnements
$queryPrepared = $pdo->prepare("SELECT ID_SUBSCRIPTION FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :id;");
$queryPrepared->execute(['id' => $_SESSION['id']]);
$subs = $queryPrepared->fetchAll();

//pour chaque abonné
foreach ($subs as $sub) {

    //on récupère chaque recette de l'abonnement actuel
    $queryPrepared = $pdo->prepare("SELECT *, PSEUDO FROM RECIPES, USER WHERE ID = :id AND ID_CREATOR = :id;");
    $queryPrepared->execute(['id' => $sub[0]]);
    $recipes = $queryPrepared->fetchAll();

    //pour chaque recette de l'abonnement on affiche la card
    foreach ($recipes as $recipe) {
        echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
            <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                <a href="https://cookit.ovh/recette.php?id=' . $recipe['ID_RECIPE'] . '">
                <img src="' . $recipe['PICTURE_PATH'] . '" class="card-img-top cardh"> </img>
                <div class="card-body text-center arrondie">
                            <h4 class="text-white">' . $recipe['TITLE'] . '</h4>
                            <a href="https://cookit.ovh/profil.php?id=' . $recipe['ID_CREATOR'] . '" class=" btn btn-secondary" style="height : 30px"><p>Créé par ' . $recipe['PSEUDO'] . '</p></a>
                </div>';
        if (isAdmin()) {
            echo '<div class="text-right">
                            <a href="https://cookit.ovh/delRecette.php?id=' . $recipe['ID_RECIPE'] . '"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                        </div>';
        }
        echo '</a>        
            </div>
        </div>';
    }
}
?>
<?php include "template/footer.php"; ?>