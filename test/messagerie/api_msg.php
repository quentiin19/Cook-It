<?php
session_start();
include '../../functions.php';


header("Content-type: application/json");

$error = array();

if($_GET['task'] == "write"){
    $sender = $_GET['sender'];
    $receveur = $_GET['receiver'];
    $msg = $_GET['msg'];
    $token = $_GET['token'];

    $pdo = connectDB();

    
    //Verification du token (Verifier que la personne est bien connectée)
    $queryPrepared = $pdo->prepare("SELECT TOKEN FROM USER WHERE ID = :sender;");
    $queryPrepared->execute(['sender'=>$sender]);
    $tokenbdd = $queryPrepared->fetch();

    if($tokenbdd[0] == $token){
        //Verification que l'un est bien abonné à l'autre
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["sender"=>$sender, "receveur"=>$receveur]);
        $state1 = $queryPrepared->fetch();
        
        //vérification que l'autre est bien abonné à l'un
        $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
        $queryPrepared->execute(["receveur"=>$sender, "sender"=>$receveur]);
        $state2 = $queryPrepared->fetch();
        

        //si les deux sont amis
        if(isset($state1[0]) && isset($state2[0])){
            if ($state1[0] == 1 && $state2[0] == 1){
                $queryPrepared = $pdo->prepare("INSERT INTO MESSAGE VALUES (CURRENT_TIME, :sender, :receveur, :msg);");
                $queryPrepared->execute(['sender'=>$sender, 'receveur'=>$receveur, 'msg'=>$msg]);
            }else{
                //les deux membres ne sont pas amis
                $error[] = 'les deux membres ne sont pas amis';
            }
        }else{
            $error[] = 'les deux membres ne se sont pas demandés en amis';
        }
        
    }else{
        //pas connecté
        $error[] = 'vous netes pas connecté';
    }


}elseif ($_GET['task'] == "read") {
    $sender = $_GET['sender'];
    $receveur = $_GET['receiver'];
    $token = $_GET['token'];

    $pdo = connectDB();
    
    //Verification du token (Verifier que la personne est bien connectée)
    $queryPrepared = $pdo->prepare("SELECT TOKEN FROM USER WHERE ID = :sender;");
    $queryPrepared->execute(['sender'=>$sender]);
    $tokenbdd = $queryPrepared->fetch();

    if($tokenbdd[0] == $token){

        //récupération de tous les messages entre les deux memebres
        $queryPrepared = $pdo->prepare("SELECT * FROM MESSAGE WHERE (ID_SENDER = :sender AND ID_RECEIVER = :receveur) OR (ID_SENDER = :receveur AND ID_RECEIVER = :sender);");
        $queryPrepared->execute(["sender"=>$sender, "receveur"=>$receveur]);
        $results = $queryPrepared->fetchAll();

        echo json_encode($results);
    }else{
        //pas connecté
        $error[] = 'vous netes pas connecté';
    }


}else {
    $error[] = 'mauvaise tache';
}


if (!empty($error)) {
    echo json_encode($error);
}
