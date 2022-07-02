<?php
include 'template/header.php';

$id = $_GET['id'];
$action = $_GET['action']

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
                        $queryPrepared = $pdo->prepare("UPDATE USER SET STATUS = -1 WHERE ID = :id;");
                        $queryPrepared->execute(['id'=>])
                    }
                }else{

                }
                break;
        
            case 'unblock':
                if ($state1[0] != -1) {
                    break;
                }else{
                    //mettre 0 en bdd
                }
                break;
        
            case 'sub':
                if ($state1[0] == 1) {
                    break;
                }else{
                    //mettre 1 en bdd
                }
                break;

            case 'unsub':
                if ($state1[0] != 1) {
                    break;
                }else{
                    //mettre 0 en bdd
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