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
            $queryPrepared = $pdo->prepare("SELECT ID FROM RECIPES WHERE TITLE LIKE :word;");
            $queryPrepared->execute(["word"=>"%".$word."%"]);
            $queryResults[$index] = $queryPrepared->fetchAll();
        }

        $results = array();
        print "<pre>";
        print_r($queryResults);
        print "</pre>";

        //clean de la recherche (retirer les recettes qui sont en plusieurs itérations)
        for ($i = 0; $i < count($queryResults); $i++) { 
            for ($j = 0; $j < count($queryResults[$i]); $j++) { 

                //Si l'id de la recette existe déjà dans le tableau de résultats
                if ($results[$queryResults[$i][$j][0]] != NULL) {
                    //on rajoute 1 à la pertinence de la recherche
                    $results[$queryResults[$i][$j][0]][1] += 1;

                //Sinon, on l'insert dans le tableau de résultats
                }else {
                    $temp1 = array($queryResults[$i][$j][0], 1);
                    $temp2 = array($queryResults[$i][$j][0] => $temp1);

                    array_merge($results, $temp2);
                }
            }
        }

        //fonction de swap
        function swap($a, $b){
            $temp = a;
            $a = $b;
            $b = $temp;
        }

        //fonction pour remettre tous les index de manière claire
        function index_clean($array){
            $i = 0;
            foreach ($array as $key => $value) {
                $key = $i;
                $i++;
            }
        }

        //fonction pour savoir si le tableau $results est trié
        function is_sort($array){
            index_clean($array);

            for ($i = 1; $i < count($array); $i++) { 
                //si la deuxième recherche est plus pertinente que la première, le tableau n'est pas trié
                if ($array[$i - 1][1] < $array[$i][1]) {
                    return false;
                }
            }
        }

        //enfin, nous trions le table du plus pertinent au moin pertinent
        /*
        while (is_sort($results)) {
            for ($i = 0; $i < count($results); $i++) { 
                if ($array[$i - 1][1] < $array[$i][1]) {
                    swap($array[$i - 1][1], $array[$i][1]);
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
        print "<pre>";
        print_r($queryResults);
        print "</pre>";
        
        print "<pre>";
        print_r($results);
        print "</pre>";
        

        
        //return json_encode($queryResults);


    }
}

$API = new API;
//header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>