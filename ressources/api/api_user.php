<?php
session_start();
include '../../functions.php';


header("Content-type: application/json");


class API{
    function returnUser($keyword){
        //connexion à la base de données
        $pdo = connectDB();

        $queryPrepared = $pdo->prepare("SELECT ID, PSEUDO, PATH_AVATAR FROM USER WHERE PSEUDO LIKE :word;");
        $queryPrepared->execute(["word"=>"%".$keyword."%"]);
        $queryResults = $queryPrepared->fetchAll();

        return json_encode($queryResults);
    }

}


$API = new API;

echo ($API->returnUser($_GET['keyword']));