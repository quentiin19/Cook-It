<?php
session_start();
include 'functions.php';


$id = $_GET['id'];
$action = $_GET['action'];

if (isConnected() == $_SESSION['id']) {
    if($_SESSION['id'] != $_GET['id']){
        //connexin à la bdd
        $pdo = connectDB();
        

        //----abonnement----
        //Verification que l'un est bien abonné à l'autre
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["sender"=>$_SESSION['id'], "receveur"=>$_GET['id']]);
        $statesub1 = $queryPrepared->fetch();

        //vérification que l'autre est bien abonné à l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
        $statesub2 = $queryPrepared->fetch();


        //----match----
        //vérification que l'autre est bien abonné à l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :receveur AND ID_MATCH = :sender");
        $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
        $statematch1 = $queryPrepared->fetch();

        //vérification que l'autre est bien abonné à l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :sender AND ID_MATCH = :receveur");
        $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
        $statematch2 = $queryPrepared->fetch();

        //----match----

        switch ($action) {
            case 'match':
                if (isset($statematch1[0])){
                    if ($statematch2[0] == -1 || ($statematch1[0] == 2) || ($statematch2[0] == 2) || ($statematch1[0] == 1 && $statematch1[0] == 1)) {
                        break;
                    }elseif($statematch1[0] == 1 || $statematch2[0] == 1){
                        //mettre 2 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = 2 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);

                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = 2 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_GET['id'], 'id_receveur'=>$_SESSION['id']]);

                    }else{
                        //mettre 1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = 1 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre 1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO MATCHS VALUES (:id_sender, :id_receveur, 1, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
        
            case 'rmatch':
                if (isset($statematch2[0])){
                        //mettre 2 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = 0 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_GET_SESSION['id'], 'id_receveur'=>$_SESSION['id']]);
                }
                break;
            
            case 'block':
                if (isset($statematch1[0])){
                    if ($statematch1[0] == -1) {
                        break;
                    }else{
                        //mettre -1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = -1 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre -1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO MATCHS VALUES (:id_sender, :id_receveur, -1, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
        
            case 'unblock':
                if (isset($statematch1[0])){
                    if ($statematch1[0] != -1) {
                        break;
                    }else{
                        //mettre 0 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE MATCHS SET STATUS = 0 WHERE ID_MATCHER = :id_sender; AND ID_MATCH = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre 0 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO MATCHS VALUES (:id_sender, :id_receveur, 0, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
        
            case 'sub':
                echo 'sub';
                if (isset($statesub1[0])){
                    if ($statesub1[0] == 1) {
                        break;
                    }else{
                        echo'update';
                        //mettre 1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = 1 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    echo 'insert';
                    //mettre 1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO SUBSCRIPTION VALUES (:id_sender, :id_receveur, 1, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;

            case 'unsub':
                if (isset($statesub1[0])){
                    if ($statesub1[0] != 1) {
                        break;
                    }else{
                        //mettre 0 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = 0 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre 0 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO SUBSCRIPTION VALUES (:id_sender, :id_receveur, 0, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
                        
            default:
                echo 'erreur, veuillez retenter ultérieurement...';
                echo '<a href="login.php">Se connecter</a>';
                break;
        }
    }else{
        //header("Location: login.php");
    }
}else{
    //header("Location: login.php");
}
//header("Location: profil.php?id=".$id);