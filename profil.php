<?php
include "template/header.php";
?>
        <?php 
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT ID_RECIPE, PICTURE_PATH, TITLE, PSEUDO FROM RECIPES, USER WHERE  RECIPES.ID_CREATOR = :id ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute(["id" => $_SESSION["id"]]);
        $results = $queryPrepared->fetchAll();

        foreach ($results as $result){
            echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="https://cookit.ovh/recette.php?id='.$result['ID_RECIPE'].'">
                        <img src="'.$result['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4>'.$result['TITLE'].'</h4>
                                    <p>Créé par '.$result['PSEUDO'].'</p>
                        </div>
                        </a>        
                    </div>
                </div>';
        }


        ?>

         <script src="ressources/js/ajax.js"></script>
    </body>
</html>