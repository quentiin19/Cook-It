<?php
include "template/header.php";

//connexion à la bdd
$pdo = connectDB();

//récupération des recettes enregistrées et du pseudo du créateur de la recette
$queryPrepared = $pdo->prepare("SELECT RECIPES.ID_RECIPE, RECIPES.PICTURE_PATH, RECIPES.TITLE, RECIPES.ID_CREATOR, USER.PSEUDO from RECIPES_SAVED, RECIPES, USER where RECIPES.ID_RECIPE = RECIPES_SAVED.ID_RECIPE AND RECIPES_SAVED.ID_USER = :id AND RECIPES.ID_CREATOR = USER.ID order by RECIPES_SAVED.DATE_SAVED DESC");
$queryPrepared->execute(['id' => $_SESSION['id']]);
$recipes = $queryPrepared->fetchAll();


foreach ($recipes as $recipe) {
    echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
            <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                <a href="https://cookit.ovh/recette.php?id=' . $recipe['ID_RECIPE'] . '">
                    <img src="' . $recipe['PICTURE_PATH'] . '" class="card-img-top cardh"> </img>
                    <div class="card-body text-center arrondie">
                        <h4 class="text-white">' . $recipe['TITLE'] . '</h4>
                        <a href="https://cookit.ovh/profil.php?id=' . $recipe['ID_CREATOR'] . '" class=" btn btn-secondary" style="height : 30px"><p>Créé par ' . $recipe['PSEUDO'] . '</p></a>
                    </div>';
            //si la personne est admin on affiche le bouton pour supprimer la recette
            if (isAdmin()) {
                echo '<div class="text-right">
                        <a href="https://cookit.ovh/delRecette.php?id=' . $recipe['ID_RECIPE'] . '"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                    </div>';
                }
            echo '</a>        
            </div>
        </div>';
}
?>
<?php include "template/footer.php"; ?>

<!-- </div> -->