<?php

require '../../functions.php';

class API{
    function ReturnRecipe($key_words){
        //connexion à la base de données
        $pdo = connectDB();

        $array_key_words = explode('-', $key_words);
        $tarte = "tarte";

        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE TITLE LIKE '%:word%';");
        $queryPrepared->execute(["word"=>$tarte]);
        $results = $queryPrepared->fetchAll();

        


        print_r($results);
        //return json_encode($results);

    }
}

$API = new API;
//header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>