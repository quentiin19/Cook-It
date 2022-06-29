<?php
include "template/header.php";
?>
        <?php
        $pdo = connectDB();

        $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE  USER.ID = :id;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $us = $queryPrepared->fetchAll();

        // $queryPrepared = $pdo->prepare("SELECT COUNT(ID) FROM SUBSCRIPTION WHERE  SUBSCRIPTION.ID_DEMANDEUR = :id WHERE STATUS = 1;");
        // $queryPrepared->execute(["id" => $_GET["id"]]);
        // $abn = $queryPrepared->fetch();

        // $queryPrepared = $pdo->prepare("SELECT COUNT(ID) FROM SUBSCRIPTION WHERE  SUBSCRIPTION.ID_RECEVEUR = :id WHERE STATUS = 1;");
        // $queryPrepared->execute(["id" => $_GET["id"]]);
        // $abonnement = $queryPrepared->fetch();

        ?>

        <div class="row">
            <div class="container bg-color justify-content-center py-5">
                <div class="col-lg-3">
                    <img src="<?= $us['PATH_AVATAR']?>" class="rounded float-start" alt="avatar">
                </div>
                <div class="col-lg-2">
                    <h3>Recettes</h3><br>
                    <h3 class="bold">4</h3>
                </div>
                <div class="col-lg-2">
                    <h3>Abonnés</h3><br>
                    <h3 class="bold">20</h3>
                </div>
                <div class="col-lg-2">
                    <h3>Abonnement</h3><br>
                    <h3 class="bold">20</h3>
                </div>
        </div>







        



<!-- Affichage des recettes crée par l'utilisateur -->
        <?php 

        
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE  RECIPES.ID_CREATOR = :id  ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $results = $queryPrepared->fetchAll();

        foreach ($results as $result){
            echo '<div class="d-flex justify-content-center">
                    <div class="col-lg-4 col-md-4 col-sm-1 py-3">
                        <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                            <a href="https://cookit.ovh/recette.php?id='.$result['ID_RECIPE'].'">
                            <img src="'.$result['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                            <div class="card-body text-center arrondie">
                                        <h4>'.$result['TITLE'].'</h4>   
                            </div>
                            </a>        
                        </div>
                    </div>
                </div>';
        }


        ?>


    </body>
</html>