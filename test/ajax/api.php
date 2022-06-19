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

            array_push($result, $recipes[$index_max]);
            unset($recipes[$index_max]);
            unset($pertinence[$index_max]);

            //si tous les éléments ont été enlevés, le tri est fini
            if (empty($recipes)){
                $is_finished = 1;
            }

        }

        $json_recipes = [];
        foreach ($result as $index => $recipe_id) {
            $queryPrepared = $pdo->prepare("SELECT ID_CREATOR, TITLE, PICTURE_PATH FROM RECIPES WHERE ID=:id;");
            $queryPrepared->execute(["id"=>$recipe_id]);
            $queryResults = $queryPrepared->fetch();

            array_push($json_recipes, $queryResults);
        }



        print '<pre>';
        print_r($json_recipes);
        print '</pre>';
        return json_encode($json_recipes);
    }
}

$API = new API;
header('Content-Type: application/json');
echo $API->ReturnRecipe($_GET['keywords']);


?>