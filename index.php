<?php
include "template/header.php";

if(isConnected()){
    echo '<p id="id-user" hidden="hidden">'.$_SESSION['id'].'</p>';
    echo '<p id="token-user" hidden="hidden">'.$_SESSION['token'].'</p>';
}
$p=$_GET['p'];
?>
<div>
        <input type="text" id="search-bar-recipe" placeholder="rechercher" class="text-center">
        <div id="recettes">

        <?php 
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT ID_RECIPE, PICTURE_PATH, TITLE, ID_CREATOR, PSEUDO FROM RECIPES, USER WHERE USER.ID = RECIPES.ID_CREATOR ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute();
        $recipes = $queryPrepared->fetchAll();
        $pmax = ceil(count($recipes) / 20); //Calcule le nombre de pages totales

        for($i = ($p*20); $i< ($p*20 + 19); $i++){
            echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="https://cookit.ovh/recette.php?id='.$recipes[$i]['ID_RECIPE'].'">
                        <img src="'.$recipes[$i]['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4 class="text-white">'.$recipes[$i]['TITLE'].'</h4>
                                    <a href="https://cookit.ovh/profil.php?id='.$recipes[$i]['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipe['PSEUDO'].'</p></a>
                        </div>';
                        if (isAdmin()){
                            echo'<div class="text-right">
                                    <a href="https://cookit.ovh/delRecette.php?id='.$recipes[$i]['ID_RECIPE'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                                </div>';
                        }
                        
                        echo'</a>        
                    </div>
                </div>';
        }
        // foreach ($recipes as $recipe){
        //     echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
        //             <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
        //                 <a href="https://cookit.ovh/recette.php?id='.$recipe['ID_RECIPE'].'">
        //                 <img src="'.$recipe['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
        //                 <div class="card-body text-center arrondie">
        //                             <h4 class="text-white">'.$recipe['TITLE'].'</h4>
        //                             <a href="https://cookit.ovh/profil.php?id='.$recipe['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipe['PSEUDO'].'</p></a>
        //                 </div>';
        //                 if (isAdmin()){
        //                     echo'<div class="text-right">
        //                             <a href="https://cookit.ovh/delRecette.php?id='.$recipe['ID_RECIPE'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
        //                         </div>';
        //                 }
                        
        //                 echo'</a>        
        //             </div>
        //         </div>';
        // }
        ?>

        </div>
    </div>
        <!-- PAGINATION --> 
        <div class="row">
            <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item disabled">
                <a class="page-link" href="
                <?php 
                if ($_GET['p'] == 0){
                    echo'#';
                }else{
                    echo'https://cookit.ovh/index.php?='.($_GET['p'] -1);
                }
                ?>">Previous</a>
                </li>
                <li>
                    <p> Pages : <?=$_GET['p'] .'/'.$pmax ?> </p> 
                </li>
                <li class="page-item">
                <a class="page-link" href="
                <?php 
                if ($_GET['p'] == $pmax){
                    echo'#';
                }else{
                    echo'https://cookit.ovh/index.php?='.($_GET['p'] +1);
                }
                ?>">Next</a>
                </li>
            </ul>
            </nav> 
        </div>



        <script src="ressources/js/ajax.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <?php // include "template/footer.php";?>


<!-- PAGINATION --> 

