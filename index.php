<?php
include "template/header.php";

if(isConnected()){
    echo '<p id="id-user" hidden="hidden">'.$_SESSION['id'].'</p>';
    echo '<p id="token-user" hidden="hidden">'.$_SESSION['token'].'</p>';
}
?>

        <input type="text" id="search-bar-recipe" placeholder="rechercher" class="text-center">
        <div id="recettes">

        <?php 
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT ID_RECIPE, PICTURE_PATH, TITLE, ID_CREATOR, PSEUDO FROM RECIPES, USER WHERE USER.ID = RECIPES.ID_CREATOR ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute();
        $recipes = $queryPrepared->fetchAll();

        foreach ($recipes as $recipe){
            echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="https://cookit.ovh/recette.php?id='.$recipe['ID_RECIPE'].'">
                        <img src="'.$recipe['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4 class="text-white">'.$recipe['TITLE'].'</h4>
                                    <a href="https://cookit.ovh/profil.php?id='.$recipe['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipe['PSEUDO'].'</p></a>
                        </div>';
                        if (isAdmin()){
                            echo'<div class="text-right">
                                    <a href="https://cookit.ovh/delRecette.php?id='.$recipe['ID_RECIPE'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                                </div>';
                        }
                        
                        echo'</a>        
                    </div>
                </div>';
        }
        ?>

        </div>

        <script src="ressources/js/ajax.js"></script>
        <?php // include "template/footer.php";?>


