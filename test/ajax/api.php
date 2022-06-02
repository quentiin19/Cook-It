<?php

require '../../functions.php';

class API{
    function ReturnRecipe($key_words){
        //connexion à la base de données
        $pdo = connectDB();

        //séparation de tous les mots dans un tableau
        $array_key_words = explode('-', $key_words);

        //pour chaque mots, on recherche dans la BDD si une recette correspond
        foreach ($array_key_words as $index=>$word) {
            $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE TITLE LIKE :word;");
            $queryPrepared->execute(["word"=>"%".$word."%"]);
            $results[$index] = $queryPrepared->fetchAll();
        }


        //clean de la recherche (retirer les recettes qui sont en plusieurs itérations)
        /*
        for ($i = 0; $i < count($results[0]); $i++) { 
            for ($j = 0; $j < count($results); $j++) { 
                for ($k = 0; $k < count($results[0]); $k++) { 
                    
                }
            }
        }
        */








        /*
        morceau de code pour récupérer les recettes en fonciton d'un mot
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE TITLE LIKE :word;");
        $queryPrepared->execute(["word"=>"%".$tarte."%"]);
        $results = $queryPrepared->fetchAll();
        */
        
        /*
        print "<pre>";
        print_r($results);
        print "</pre>";
        */

        for ($i = 0; $i < count($results); $i++) { 
            $results[$i] = json_encode($results[$i]);
        }
        return $results;

    }
}

$API = new API;
header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>