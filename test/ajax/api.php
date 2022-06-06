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
                if (array_search($queryResults[$i], $recipes) != false){
                    $index = array_search($queryResults[$i], $recipes);
                    $pertinence[$index] += 1; 
                    
                }else{
                    //on rajoute la recette dans les recettes qui ressortent de la recherche
                    array_push($recipes, $queryResults[$i]);
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
            /*
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
            */

            //si tous les éléments ont été enlevés, le tri est fini
            if (empty($recipes)){
                $is_finished = 1;
            }

            //on définit une variable qui hébergera la pertinence maximum
            $index_max = 0;
            $max_pert = 0;
            $max_reci = 0;

            for ($i = 0; $i < count($recipes); $i++) { 
                if (isset($recipes[$i])) {
                    if ($pertinence[$i] >= $max_pert) {
                        $index_max = $i;
                        $max_pert = $pertinence[$i];
                        $max_reci = $recipes[$i];
                    }
                }
            }

            array_push($result, $recipes[$index_max]);
            unset($recipes[$index_max]);
            unset($pertinence[$index_max]);

        }
        
        return json_encode($result);
    }
}

$API = new API;
//header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>