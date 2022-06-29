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
            <div class="container-fluid bg-color justify-content-center my-3 py-5">
                <div class="col-lg-5">
                    <img src="<?= $us['PATH_AVATAR']?>" class="text-right" alt="avatar">
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="my-2">
                            <h4>@Pseudo</h4>
                        </div>
                    </div>          
                    <div class="row">
                        <div class="col-lg-4">
                            <h4>Recettes : 12 </h4>
                        </div>
                        <div class="col-lg-4">
                            <h4>Abonnés : 20 </h4>
                        </div>
                        <div class="col-lg-4">
                            <h4>Abonnement : 15</h4>
                        </div>

                    </div>
                </div>
            </div>         
        </div>







        



<!-- Affichage des recettes crée par l'utilisateur -->
        <?php 

        
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE  RECIPES.ID_CREATOR = :id  ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $results = $queryPrepared->fetchAll();

        
        echo'
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">';
        foreach ($results as $result){
            echo '
                    <div class="col-lg-4 col-md-4 col-sm-1 py-3">
                        <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                            <a href="https://cookit.ovh/recette.php?id='.$result['ID_RECIPE'].'">
                            <img src="'.$result['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                            <div class="card-body text-center arrondie">
                                        <h4>'.$result['TITLE'].'</h4>   
                            </div>
                            </a>        
                        </div>
                    </div>';
        }
        echo '
            </div>
            <div class="col-lg-2"></div>
        </div>';


        ?>


    </body>
</html>