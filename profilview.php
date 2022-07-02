<?php include "template/header.php";?>
<?php
if (isConnected()) {
?>
<div class="row" height = "100%" >
    <div class="col-lg-2 col-md-2 col-sm-2 bg-color my-3 ml-5 arrondie ">
<div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/profilview.php?id=<?= $_SESSION['id']?>" >Mon profil</a>
                </div>
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/modif_profil.php?id=<?= $_SESSION['id']?>" >Modifier mon profil</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5  py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/avatar.php?id=<?= $_SESSION['id']?>" >Modifier mon avatar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/modif_email.php?id=<?= $_SESSION['id']?>" >Modifier mon email</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-4 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/pwdmodif.php?id=<?= $_SESSION['id']?>" >Modifier mon mot de passe</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/test/fpdf/download_log.php?id=<?= $_SESSION['id'] ?>" >Télécharger mes logs</a>
                </div>
            </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 bg-coleur">
<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie d-flex justify-content-center  ">
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

        //récupération du nombre d'abonnement de ce profil qu'il n'a pas accepté
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_SUBSCRIPTION) FROM SUBSCRIPTION WHERE SUBSCRIPTION.ID_SUBSCRIBER = :id AND STATUS = 0;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $friendR = $queryPrepared->fetch();
        
        //affichages des boutons sur le profil
if (isConnected()){
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
}

        /*
        tous les états possibles :
        u = 1 p = 1     messages supprimer bloquer
        u = 1 p = 0     supprimer bloquer
        u = 1 p = -1    supprimer bloquer

        u = 0 p = 1     s'abonner bloquer
        u = 0 p = 0     s'abonner bloquer
        u = 0 p = -1    bloquer

        u = -1 p = 1    débloquer
        u = -1 p = 0    débloquer
        u = -1 p = -1   débloquer
        */


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
                    if(isConnected()){
                        //s'il s'agit de la page d'un autre utilisateur
                        if($ownpage == 0){
                            //si une relation existe déjà
                            if(isset($state1[0])){
                                //si l'utilisateur a déjà ce profil en ami
                                if($state1[0] == 1){
                                    //si l'utilisateur du profil a déjà l'utilisateur en ami
                                    if($state2[0] == 1){
                                        //afficher le bouton message
                                        echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                            <a href="https://cookit.ovh/messagerie.php?id='.$_GET['id'].'" class=" btn btn-secondary" style="height : 30px"><p>Message</p></a>
                                        </div>';
    
                                    }
                                    //afficher le bouton supprimer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=unsub" class=" btn btn-secondary" style="height : 30px"><p>Désabonner</p></a>
                                    </div>';
                                    
                                    //afficher le bouton bloquer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                            <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=block" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                        </div>';
    
                                }elseif($state1[0] == 0){
                                    //affichage du bouton s'abonner
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=sub" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                                    </div>';
    
                                    //afficher le bouton bloquer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=block" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                    </div>';

                                }elseif($state1[0] == -1) {
                                    //afficher le bouton pour débloquer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=unblock" class=" btn btn-secondary" style="height : 30px"><p>Débloquer</p></a>
                                    </div>';
    
                                }
                            //sinon si 
                            }elseif(!isset($state2[0]) || $state2[0] == 1) {
                                //affichage du bouton s'abonner
                                echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=sub" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                                </div>';

                                //afficher le bouton bloquer
                                echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="https://cookit.ovh/social-action.php?id='.$_GET['id'].'&action=block" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                </div>';

                            }
                        
                        //sinon, il s'agit de la propre page du user
                        }else{
                            echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="modif_profil.php" class=" btn btn-secondary" style="height : 30px"><p>Modifier mon profil</p></a>
                                </div>';
                        }
                        




                        // if ($user['ID'] == $_SESSION['id']){
                        //     echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        //             <a href="modif_profil.php" class=" btn btn-secondary" style="height : 30px"><p>Modifier mon profil</p></a>
                        //         </div>';
                        // }else{
                        //     echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        //             <a href="#" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                        //         </div>';
                        // }
                    }
                    ?>

                    </div>          
                    <div class="row my-5">
                        <div class="col-lg-4 ">
                            <h4>Recettes : <?= $nbrecipe[0]?></h4>
                        </div>
                        <div class="col-lg-4">
                            <a class="text-white" href="<?= 'https://cookit.ovh/viewsub.php?id='.$_GET['id'].'&display=1'?>"><h4>Abonnement : <?= $abonnement[0]?></h4><a> 
                        </div>
                        <div class="col-lg-4">
                            <a class="text-white" href="<?= 'https://cookit.ovh/viewsub.php?id='.$_GET['id'].'&display=2'?>"><h4>Abonnés : <?= $abonnes[0]?></h4><a>
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
</div>






    



<!-- Affichage des recettes crée par l'utilisateur -->
        <?php 

        
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE  RECIPES.ID_CREATOR = :id  ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $results = $queryPrepared->fetchAll();

        
        echo'
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">';
            
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
            
        </div>';


        ?>
			</div>
		</div>
	</div>
</div>

<?php include "template/footer.php";?>
<?php
}
?>