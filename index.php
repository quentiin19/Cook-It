<?php
include "template/header.php";

if(isConnected()){
    echo '<p id="id-user" hidden="hidden">'.$_SESSION['id'].'</p>';
    echo '<p id="token-user" hidden="hidden">'.$_SESSION['token'].'</p>';
}

if(!isset($_GET['p'])){
    header("Location: index.php?p=1");
}

$p = $_GET['p'];
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<div>   
        <div class="d-flex justify-content-center my-3">
            <input type="text" id="search-bar-recipe" placeholder="rechercher une recette" class="text-center">
        </div>
        <div id="recettes"></div>

        <div id="recettes-php">

        <?php 
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT ID_RECIPE, PICTURE_PATH, TITLE, ID_CREATOR, PSEUDO FROM RECIPES, USER WHERE USER.ID = RECIPES.ID_CREATOR ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute();
        $recipes = $queryPrepared->fetchAll();
        $pmax = ceil(count($recipes) / 20); //Calcule le nombre de pages totales


        if ((($p - 1) * 20 + 19)> count($recipes) -1){
            $q = count($recipes);
        }else{
            $q = ($p - 1) * 20 + 20;
        }

        for($i = (($p - 1) * 20); $i < $q; $i++){
            echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="https://cookit.ovh/recette.php?id='.$recipes[$i]['ID_RECIPE'].'">
                        <img src="'.$recipes[$i]['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4 class="text-white">'.$recipes[$i]['TITLE'].'</h4>
                                    <a href="https://cookit.ovh/profil.php?id='.$recipes[$i]['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipes[$i]['PSEUDO'].'</p></a>
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
        <div id="next-prev" class="row">
            <div class="d-flex justify-content-center mb-5 ">

                <button type="button" class="btn btn-secondary mx-3 text-white"><a class="text-white" href="
                    <?php 
                    if ($p == 1){
                        echo'#';
                    }else{
                        echo'https://cookit.ovh/index.php?p='.($p -1);
                    }
                    ?>">Previous</a></button>
                    
                        <p class="my-3"> Pages : <?=$p .'/'.$pmax ?> </p> 
                    
                    
                    <button type="button" class="btn btn-secondary mx-3 "><a class="text-white"  href="
                    <?php 
                    if ($p == $pmax){
                        echo'#';
                    }else{
                        echo'https://cookit.ovh/index.php?p='.($p + 1);
                    }
                    ?>">Next</a></button>
                    
                
            </div>
        </div>



        <script src="ressources/js/ajax_recette.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        


<!-- PAGINATION --> 

