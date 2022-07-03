<?php
include "template/header.php";
?>

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
if (isConnected()) {
    if ($_SESSION['id'] != $_GET['id']) {
        $ownpage = 0;

        //Verification que l'un est bien abonné à l'autre
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["sender" => $_SESSION['id'], "receveur" => $_GET['id']]);
        $statesub1 = $queryPrepared->fetch();

        if (isset($statesub1[0])) {
            if ($statesub1[0] == 1) {
                $subbtn = 0;
                $unsubbtn = 1;
            } else {
                $subbtn = 1;
                $unsubbtn = 0;
            }
        } else {
            $subbtn = 1;
            $unsubbtn = 0;
        }


        //Verification que l'un a bien match avec l'autre
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :sender AND ID_MATCH = :receveur");
        $queryPrepared->execute(["sender" => $_SESSION['id'], "receveur" => $_GET['id']]);
        $statematch1 = $queryPrepared->fetch();

        //vérification que l'autre a bien match avec l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :sender AND ID_MATCH = :receveur");
        $queryPrepared->execute(["receveur" => $_SESSION['id'], "sender" => $_GET['id']]);
        $statematch2 = $queryPrepared->fetch();

        //mise en place des conditions d'affichage des boutons
        if (isset($statematch1[0]) && isset($statematch2[0])) {
            if ($statematch1[0] == -1) {
                $unblockbtn = 1;
                $blockbtn = 0;
                $msgbtn = 0;
                $matchbtn = 0;
            } elseif ($statematch2[0] == -1) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 0;
            } elseif ($statematch1[0] == 0) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 1;
            } elseif ($statematch1[0] == 1 && $statematch2[0] == 1) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 1;
                $matchbtn = 0;
            } elseif ($statematch1[0] == 1) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 0;
            }
        } elseif (isset($statematch1[0])) {
            if ($statematch1[0] == -1) {
                $unblockbtn = 1;
                $blockbtn = 0;
                $msgbtn = 0;
                $matchbtn = 0;
            } elseif ($statematch1[0] == 0) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 1;
            } else {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 0;
            }
        } elseif (isset($statematch2[0])) {
            if ($statematch2[0] == -1) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 0;
            } elseif ($statematch2[0] == 0) {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 1;
            } else {
                $unblockbtn = 0;
                $blockbtn = 1;
                $msgbtn = 0;
                $matchbtn = 1;
            }
        } else {
            $unblockbtn = 0;
            $blockbtn = 1;
            $msgbtn = 0;
            $matchbtn = 1;
        }
    } else {
        $ownpage = 1;
    }
} else {
    header("Location: login.php");
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
        <div class="col-lg-5 my-5 py-5">
            <img src=".<?= $user['PATH_AVATAR'] ?>" class="text-right cardh" alt="avatar.png">
        </div>
        <div class="col-lg-7 col-md-5">
            <div class="row">
                <div class="col-lg-6 col-md-6 py-5">
                    <h2 class="  my-4"><?= $user['PSEUDO'] ?></h2>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <?php
                        if (isConnected()) {
                            //s'il s'agit de la page d'un autre utilisateur
                            if ($ownpage == 0) {

                                if ($subbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id=' . $_GET['id'] . '&action=sub" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                                    </div>';
                                }
                                if ($unsubbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id=' . $_GET['id'] . '&action=unsub" class=" btn btn-secondary" style="height : 30px"><p>Se Désabonner</p></a>
                                    </div>';
                                }
                                if ($unblockbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id=' . $_GET['id'] . '&action=unblock" class=" btn btn-secondary" style="height : 30px"><p>Débloquer</p></a>
                                    </div>';
                                }
                                if ($blockbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id=' . $_GET['id'] . '&action=block" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                    </div>';
                                }
                                if ($msgbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/messagerie.php?id=' . $_GET['id'] . '" class=" btn btn-secondary" style="height : 30px"><p>Message</p></a>
                                    </div>';
                                }
                                if ($matchbtn == 1) {
                                    echo '<div class="btn col-lg-12 col-md-12 d-flex justify-content-end">
                                        <a href="https://cookit.ovh/social-action.php?id=' . $_GET['id'] . '&action=match" class=" btn btn-secondary" style="height : 30px"><p>Match <3</p></a>
                                    </div>';
                                }
                            }
                        }
                        ?>
                        <!-- fermeture row -->
                    </div>
                    <!-- fermeture div -->
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-4 ">
                    <h4>Recettes : <?= $nbrecipe[0] ?></h4>
                </div>
                <div class="col-lg-4">
                    <a class="text-white" href="<?= 'https://cookit.ovh/viewsub.php?id=' . $_GET['id'] . '&display=1' ?>">
                        <h4>Abonnement : <?= $abonnement[0] ?></h4>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a class="text-white" href="<?= 'https://cookit.ovh/viewsub.php?id=' . $_GET['id'] . '&display=2' ?>">
                        <h4>Abonnés : <?= $abonnes[0] ?></h4>
                    </a>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-12 ">
                    <h4>Description : </h4><br>
                    <p class="d-flex text-white py-3 px-3"><?= $user['DESCRIPTION_PROFIL'] ?></p><br>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include "template/footer.php"; ?>









<!-- Affichage des recettes crée par l'utilisateur -->
<?php


$queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE  RECIPES.ID_CREATOR = :id  ORDER BY RECIPES.ID_RECIPE DESC;");
$queryPrepared->execute(["id" => $_GET["id"]]);
$results = $queryPrepared->fetchAll();


echo '<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">';

    foreach ($results as $result) {
        echo '<div class="col-lg-4 col-md-4 col-sm-1 py-3">
                <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                    <a class="text-white" href="https://cookit.ovh/recette.php?id=' . $result['ID_RECIPE'] . '">
                        <img src="' . $result['PICTURE_PATH'] . '" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4>' . $result['TITLE'] . '</h4>   
                        </div>
                    </a>        
                </div>
            </div>';
    }
    echo '</div>
    </div>';


?>


</body>

</html>