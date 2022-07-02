<?php
session_start();
include '../../functions.php';


header("Content-type: application/json");


class API{
    function returnUser($keyword){
        //connexion à la base de données
        $pdo = connectDB();

        //création des tableaux qui vont permettre de gérer la pertinence des recherches
        $user = array();

        $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE PSEUDO LIKE :word;");
        $queryPrepared->execute(["word"=>"%".$keyword."%"]);
        $queryResults = $queryPrepared->fetchAll();

        echo $keyword;
        print_r($queryResults);

        return json_encode($queryResults);
    }

}


$API = new API;

return ($API->returnUser($_GET['keyword']));