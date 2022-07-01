<?php

include 'template/header.php';
?>


<div class="row" height = "100%" >
    <div class="col-lg-2 col-md-2 col-sm-2 bg-danger ">
        <div class=" d-flex  justify-content-center ">
            <div class="">
                <a href="#" >Modifier mon profil</a>
            </div>
            <div class="">
                <a href="#" >Modifier mon profil</a>
            </div>
            <div class="">
                <a href="#" >Modifier mon profil</a>
            </div>
            <div class="">
                <a href="#" >Modifier mon profil</a>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 bg-light">
    <?php
        $pdo = connectDB();

        //récupération des informations du profil
        $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE  USER.ID = :id;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $user = $queryPrepared->fetch();

        //récupération du nombre de recette créée par ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_RECIPE) FROM RECIPES WHERE ID_CREATOR = :id;");
        $queryPrepared->execute(['id' => $_GET["id"]]);
        $nbrecipe = $queryPrepared->fetch();

        //récupération du nombre d'abonnés à ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_SUBSCRIBER) FROM SUBSCRIPTION WHERE SUBSCRIPTION.ID_SUBSCRIPTION = :id AND STATUS = 1;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $abonnes = $queryPrepared->fetch();

        //récupération du nombre d'abonnement de ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_SUBSCRIPTION) FROM SUBSCRIPTION WHERE SUBSCRIPTION.ID_SUBSCRIBER = :id AND STATUS = 1;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $abonnement = $queryPrepared->fetch();


        //affichages des boutons sur le profil

        if($_SESSION['id'] != $_GET['id']){
            $ownpage = 0;

            //Verification que l'un est bien abonné à l'autre
            $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
            $queryPrepared->execute(["sender"=>$_SESSION['id'], "receveur"=>$_GET['id']]);
            $state1 = $queryPrepared->fetch();
    
            //vérification que l'autre est bien abonné à l'un
            $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
            $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
            $state2 = $queryPrepared->fetch();

        }else{
            $ownpage = 1;
        }
        ?>

<div class="row">
    <div class="container bg-color justify-content-center my-3 py-3 arrondie">
        <div class="col-lg-5">
            <img src=".<?= $user['PATH_AVATAR'] ?>" class="text-right cardh" alt="avatar.png">
        </div>
        <div class="col-lg-7 col-md-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6 my-3">
                        <h4><?= $user['PSEUDO'] ?></h4>
                    </div>



                    
                    <?php
                        //s'il s'agit de la page d'un autre utilisateur
                        if($ownpage == 0){
                            if(isset($state1[0])){
                                if($state1[0] == 1){
                                    if($state2[0] == 1){
                                        //afficher le bouton message
                                        echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                            <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Message</p></a>
                                        </div>';
    
                                    }
                                    //afficher le bouton supprimer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Désabonner</p></a>
                                    </div>';
    
                                }elseif ($state1[0] == -1) {
                                    //afficher le bouton pour débloquer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Débloquer</p></a>
                                    </div>';
    
                                }
    
                            }elseif(!isset($state2[0]) || $state2[0] == 1) {
                                //affichage du bouton s'abonner
                                echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="#" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                                </div>';

                            }

                            echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                </div>';
                        
                        //sinon, il s'agit de la propre page du user
                        }else{
                            echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="modif_profil.php" class=" btn btn-secondary" style="height : 30px"><p>Modifier mon profil</p></a>
                                </div>';
                        }
                        
                    ?>

                    </div>          
                    <div class="row my-5">
                        <div class="col-lg-3 ">
                            <h4>Recettes : <?= $nbrecipe[0]?></h4>
                        </div>
                        <div class="col-lg-3">
                            <a href="<?= 'https://cookit.ovh/viewsub.php?id='.$_GET['id'].'&display=1'?>"><h4>Abonnement : <?= $abonnement[0]?></h4><a> 
                        </div>
                        <div class="col-lg-3">
                            <a href="<?= 'https://cookit.ovh/viewsub.php?id='.$_GET['id'].'&display=2'?>"><h4>Abonnés : <?= $abonnes[0]?></h4><a>
                        </div>
                        
                    </div>
                    <div class="row my-5">
                        <div class="col-lg-3 ">
                            <h4>Description : </h4><br>
                            <p><?= $user['DESCRIPTION_PROFIL']?></p><br>    
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

    </div>
    </body>
</html>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <?php // include "template/footer.php";?>


<!-- PAGINATION --> 

