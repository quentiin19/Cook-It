<?php
include "template/header.php";
?>

        <input type="text" id="search_bar_ajax" placeholder="rechercher" class="text-center">
        <button id="search_button_ajax">rechercher</button>
        <div id="recettes">

        <?php 
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES ORDER BY ID DESC;");
        $queryPrepared->execute();
        $recipes = $queryPrepared->fetchAll();


        foreach ($recipes as $recipe){
            echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class"card cardh mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="http://cookit.ovh/recette.php?'.$recipe['ID'].'></a>
                        <img src="'.$recipe['PICTURE_PATH'].'" height : 100px> </img>
                        <div class="card-body arrondie">
                            <div class="row">
                                <div class=\"col-lg-3 col-md-3 col-sm-3\"></div>
                                <div class=\"col-lg-6 col-md-6 col-sm-6 px-2 py-2 border\">
                                    <h4>'$recipe['TITLE'].'</h4>
                                    <p>Créé par '.$recipe['PSEUDO'].'</p>
                                </div>
                                <div class=\"col-lg-3 col-md-3 col-sm-3\"></div>
                            </div>
                        </div>        
                    </div>
                </div>';
        }
        ?>

        </div>

        <script src="ressources/js/ajax.js"></script>
    </body>
</html>