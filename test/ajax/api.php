<?php

require '../../functions.php';

class API{
    function ReturnRecipe($key_words){
        //connexion à la base de données
        $pdo = connectDB();

        $array_key_words = explode('-', $key_words);

        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE TITLE LIKE '%Boeuf%';");
        $queryPrepared->execute();
        $results = $queryPrepared->fetch();

        



        return json_encode($results);

    }
}

$API = new API;
header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>