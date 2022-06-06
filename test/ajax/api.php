<?php

require '../../functions.php';

class API{
    function ReturnRecipe($key_words){
        //connexion à la base de données
        $pdo = connectDB();

        //séparation de tous les mots dans un tableau
        $array_key_words = explode('-', $key_words);

        //création des tableaux qui vont permettre de gérer la pertinence des recherches
        $recipes = array();
        $pertinence = array();

        //pour chaque mots, on recherche dans la BDD si une recette correspond
        foreach ($array_key_words as $index=>$word) {
            $queryPrepared = $pdo->prepare("SELECT ID FROM RECIPES WHERE TITLE LIKE :word;");
            $queryPrepared->execute(["word"=>"%".$word."%"]);
            $queryResults = $queryPrepared->fetchAll();

            for ($i = 0; $i < count($queryResults); $i++){ 
                if (array_search($queryResults[$i][0], $recipes, false) != false){
                    $index = array_search($queryResults[$i][0], $recipes, false);
                    $pertinence[$index] += 1; 
                    echo "trouvé";
                    
                }else{
                    //on rajoute la recette dans les recettes qui ressortent de la recherche
                    array_push($recipes, $queryResults[$i][0]);
                    //on initialise la pertinence à 1 car c'est la première itération de la recette dans la recherche
                    array_push($pertinence, 1);
                }
            }
        }

        //création du tableau $result qui sera renvoyer après l'appel de l'api
        //les recettes les plus pertinentes seront trié par index du plus petit au plus grand
        $result = array();


        $is_finished = 0;

        //on insert les recettes une par une dans le tableau $result
        while (!$is_finished) {
            echo "--------------------RECIPES-------------------------";
            print "<pre>";
            print_r($recipes);
            print "</pre>";
            echo "--------------------PERTINENCE-------------------------";
            print "<pre>";
            print_r($pertinence);
            print "</pre>";
            echo "--------------------RESULT-------------------------";
            print "<pre>";
            print_r($result);
            print "</pre>";

            

            //on définit une variable qui hébergera la pertinence maximum
            $index_max = 0;
            $max_pert = 0;
            $max_reci = 0;

            foreach ($recipes as $key => $recipe) {
                if (isset($recipes[$key])) {
                    if ($pertinence[$key] >= $max_pert) {
                        $index_max = $key;
                        $max_pert = $pertinence[$key];
                        $max_reci = $recipes[$key];
                    }
                }
            }
            /*
            for ($i = 0; $i < count($recipes); $i++) { 
                if (isset($recipes[$i])) {
                    if ($pertinence[$i] >= $max_pert) {
                        $index_max = $i;
                        $max_pert = $pertinence[$i];
                        $max_reci = $recipes[$i];
                    }
                }
            }*/

            array_push($result, $recipes[$index_max]);
            unset($recipes[$index_max]);
            unset($pertinence[$index_max]);

            //si tous les éléments ont été enlevés, le tri est fini
            if (empty($recipes)){
                $is_finished = 1;
            }

        }
        
        echo "============RESULTAT================";
        print "<pre>";
        print_r($result);
        print "</pre>";

        

        /*
        print "<pre>";
        print_r($queryResults);
        print "</pre>";

        $temp = $queryResults[0][0][0];
        $queryResults[0][0][0] = $queryResults[0][1][0];
        $queryResults[0][1][0] = $temp;




        $results = array();
        

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
            $temp = $a;
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
        
        print "<pre>";
        print_r($queryResults);
        print "</pre>";
        
        print "<pre>";
        print_r($results);
        print "</pre>";
        */
        

        
        return json_encode($queryResults);


    }
}

$API = new API;
//header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>