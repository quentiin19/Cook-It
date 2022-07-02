<?php
include "template/header.php";
?>

    <div class="col-lg-6 col-md-6 col-sm-6">
    <div class="card bg-color text-white pb-3 my-3" style="border-radius: 1rem;">
        <h3 class="text-center py-1">Ajouter les ingrédients </h3>

        <!--scroll-->
        <div>
            <div class="d-flex justify-content-center">
                <input type="text" id="search-bar-ingredient" class="  py-2 mb-3 text-dark" placeholder="rechercher un ingredient">
            </div>
            <div id="ingredients" class="overflow-auto" style="height : 500px">
                <?php
        $pdo = connectDB();

        $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
        $queryPrepared->execute();
        $results = $queryPrepared->fetchAll();

        foreach ($results as $key => $ingredient) { 
            echo '<div id="'.$ingredient['ID'].'"class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
                        <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-sm-6">
                                    <input  type="checkbox" name="checkbox'.$ingredient['ID'].'">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <p>'.$ingredient['NAME'].'</p>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 ">
                                    <input class="input-width text-dark" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
                                </div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                    '.$ingredient['UNIT'].'
                                </div>		
                        </div>
                    </div>';
            
        }?>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="card bg-color text-white pb-3 my-3" style="border-radius: 1rem;">
        <h3 class="text-center py-1">Ajouter les ingrédients </h3>

        <!--scroll-->
        <div>
            <div class="d-flex justify-content-center">
                <input type="text" id="search-bar-ingredient" class="  py-2 mb-3 text-dark" placeholder="rechercher un ingredient">
            </div>
            <div id="ingredients" class="overflow-auto" style="height : 500px">
                <?php
        $pdo = connectDB();

        $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
        $queryPrepared->execute();
        $results = $queryPrepared->fetchAll();

        foreach ($results as $key => $ingredient) { 
            echo '<div id="'.$ingredient['ID'].'"class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
                        <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-sm-6">
                                    <input  type="checkbox" name="checkbox'.$ingredient['ID'].'">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <p>'.$ingredient['NAME'].'</p>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 ">
                                    <input class="input-width text-dark" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
                                </div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                    '.$ingredient['UNIT'].'
                                </div>		
                        </div>
                    </div>';
            
        }?>
            </div>
        </div>
    </div>
</div>

<script src='ressources/js/ajax_ingredient.js'></script>
