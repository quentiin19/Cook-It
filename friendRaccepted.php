<?php 
include "template/header.php";


if (isConnected() == $_GET['id']){
    $pdo = connectDB();

    $queryPrepared = $pdo->prepare("SELECT * FROM SUBSCRIPTION WHERE ID_SUBSCRIPTION = :idsub AND ID_SUBSCRIBER = :idber;");
    $queryPrepared->execute(["idsub"=> $_GET['id'],"idber"=> $_GET['ids']]);
    $frrequest = $queryPrepared->fetch();
    
    if (!isset($frrequest)) {
        die("Could not find this request");
    }
    elseif (isset($frrequest)) {
        $queryPrepared = $pdo->prepare("update SUBSCRIPTION set STATUS = 1 WHERE ID_SUBSCRIPTION = :idsub AND ID_SUBSCRIBER = :idber; ");
        $queryPrepared->execute(["idsub"=>$_GET['id'],"idber"=>$_GET['ids']]);
    }

}