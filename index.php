<?php
include "template/header.php";
?>

        <!-- <input type="text" id="search_bar_ajax" placeholder="rechercher" class="text-center">
        <button id="search_button_ajax">rechercher</button>
        <div id="recettes"> -->

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
                                    <a href="https://cookit.ovh/profil.php?id='.$recipe['ID_CREATOR'].'" class=" btn btn-secondary""><p>Créé par '.$recipe['PSEUDO'].'</p></a>
                        </div>
                        </a>        
                    </div>
                </div>';
        }
        ?>

        <!-- </div> -->

        <script src="ressources/js/ajax.js"></script>
    </body>
</html>