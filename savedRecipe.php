<?php
include "template/header.php";


$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT * from RECIPES_SAVED,RECIPES where RECIPES.ID_RECIPE = RECIPES_SAVED.ID_RECIPE order by RECIPES_SAVED.DATE_SAVED DESC");
$queryPrepared->execute(['id'=>$_SESSION['id']]);
$recipes = $queryPrepared->fetchAll();

echo '<pre>';
print_r($recipes);
echo '</pre>';


foreach ($recipes as $recipe){
    echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
            <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                <a href="https://cookit.ovh/recette.php?id='.$recipe['ID_RECIPE'].'">
                <img src="'.$recipe['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                <div class="card-body text-center arrondie">
                            <h4 class="text-white">'.$recipe['TITLE'].'</h4>
                            <a href="https://cookit.ovh/profil.php?id='.$recipe['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipe['ID_CREATOR'].'</p></a>
                </div>';
                if (isAdmin()){
                    echo'<div class="text-right">
                            <a href="https://cookit.ovh/delRecette.php?id='.$recipe['ID_RECIPE'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                        </div>';
                }
                
                echo'</a>        
            </div>
        </div>';
}
?>

<!-- </div> -->