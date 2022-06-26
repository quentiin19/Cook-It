<?php

require '../../functions.php';

class API_VOTE{
    function CountVote($id_recipe){
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_USER) FROM VOTES WHERE ID_RECIPE=:id AND VOTE=1");
        $queryPrepared->execute(['id'=>$id_recipe]);
        $upvote = $queryPrepared->fetch();

        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_USER) FROM VOTES WHERE ID_RECIPE=:id AND VOTE=-1");
        $queryPrepared->execute(['id'=>$id_recipe]);
        $downvote = $queryPrepared->fetch();

        return ($upvote[0] - $downvote[0]);
    }

    function Vote($id_recipe, $id_user, $vote){
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT VOTE FROM VOTES WHERE ID_RECIPE=:id_recipe AND ID_USER=:id_user");
        $queryPrepared->execute(['id_recipe'=>$id_recipe, 'id_user'=>$id_user]);
        $result = $queryPrepared->fetch();
        
        if (!isset($result[0])) {
            //mise en bdd du vote
            $queryPrepared = $pdo->prepare("INSERT INTO VOTES VALUES (:id_user, :id_recipe, :vote);");
            $queryPrepared->execute(['id_user'=>$id_user, 'id_recipe'=>$id_recipe, 'vote'=>$vote]);

        }elseif ($result[0] != $vote) {
            //changement du vote en bdd
            $queryPrepared = $pdo->prepare("UPDATE VOTES SET VOTE=:vote WHERE ID_RECIPE=:id_recipe AND ID_USER=:id_user;");
            $queryPrepared->execute(['vote'=>$vote, 'id_recipe'=>$id_recipe, 'id_user'=>$id_user])
        }
    }
}


$action = $_GET['action'];

//vérification du token pour voir si le user est bien connecté

if ($action == 1) {
    //retourner le nombre de votes
    $API = new API;
    echo json_encode($API->CountVote($id_recipe));

}elseif ($action == 2) {
    //vote d'un user
    $id_recipe = $_GET['recipe']
    $id_user = $_GET['user'];
    $vote = $_GET['vote'];
    $token = $_GET['token'];

    if ($vote >= -1 && $vote <= 1) {
        $queryPrepared = $pdo->prepare("SELECT TOKEN FROM USERS WHERE ID=:id_user;");
        $queryPrepared->execute(['id_user'=>$id_user])
        $tokenbdd = $queryPrepared->fetch();
    
        if($token == $tokenbdd) {
            $API = new API;
            $API->Vote($id_recipe, $id_user, $vote);
        }else{
            die;
        }
    }else{
        die;
    }
}