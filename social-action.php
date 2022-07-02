<?php
include 'template/header.php';

$id = $_GET['id'];
$action = $_GET['action'];

if (isConnected() == $_SESSION['id']) {
    if($_SESSION['id'] != $_GET['id']){
        //connexin à la bdd
        $pdo = connectDB();

        //Verification que l'un est bien abonné à l'autre
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["sender"=>$_SESSION['id'], "receveur"=>$_GET['id']]);
        $state1 = $queryPrepared->fetch();

        //vérification que l'autre est bien abonné à l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
        $state2 = $queryPrepared->fetch();

        switch ($action) {
            case 'block':
                if (isset($state1[0])){
                    if ($state1[0] == -1) {
                        break;
                    }else{
                        //mettre -1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = -1 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre -1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO SUBSCRIPTION VALUES (:id_sender, :id_receveur, -1, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
        
            case 'unblock':
                if (isset($state1[0])){
                    if ($state1[0] != -1) {
                        break;
                    }else{
                        //mettre -1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = 0 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre -1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO SUBSCRIPTION VALUES (:id_sender, :id_receveur, 0, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;
        
            case 'sub':
                if (isset($state1[0])){
                    if ($state1[0] == 1) {
                        break;
                    }else{
                        //mettre -1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = 1 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre -1 en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO SUBSCRIPTION VALUES (:id_sender, :id_receveur, 1, NOW());");
                    $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                }
                break;

            case 'unsub':
                if (isset($state1[0])){
                    if ($state1[0] != 1) {
                        break;
                    }else{
                        //mettre -1 en bdd
                        $queryPrepared = $pdo->prepare("UPDATE SUBSCRIPTION SET STATUS = 0 WHERE ID_SUBSCRIBER = :id_sender; AND ID_SUBSCRIPTION = :id_receveur;");
                        $queryPrepared->execute(['id_sender'=>$_SESSION['id'], 'id_receveur'=>$_GET['id']]);
                    }
                }else{
                    //mettre -1 en bdd
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
        header("Location: login.php");
    }
}else{
    header("Location: login.php");
}