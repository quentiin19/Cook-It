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
            <form method="POST" action="updateFrigo.php">
                <?php
        $pdo = connectDB();

        $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID NOT IN (SELECT ID_INGREDIENT FROM FRIDGE WHERE ID_USER = :id);");
        $queryPrepared->execute(['id'=>$_SESSION['id']]);
        $results = $queryPrepared->fetchAll();
        
        foreach ($results as $key => $ingredient) { 
            echo '<div id="'.$ingredient['ID'].'"class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
                        <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-sm-6">
                                    <input  type="checkbox" name="nfcheckbox'.$ingredient['ID'].'">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <p>'.$ingredient['NAME'].'</p>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 ">
                                    <input class="input-width text-dark" type="text" name="nfquantity'.$ingredient['ID'].'" placeholder="quantité">
                                </div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                    '.$ingredient['UNIT'].'
                                </div>		
                        </div>
                        
                    </div>';
            
        }?>
        <input type="submit" value="Valider" class="text-center">
            </div>
            </div>
        </div>
    </div>
</div>

<?php

if (isConnected() == $_SESSION['id']){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT * from FRIDGE,INGREDIENTS where INGREDIENTS.ID = FRIDGE.ID_INGREDIENT AND FRIDGE.ID_USER = :id;");
	$queryPrepared->execute(["id" => $_SESSION['id']]);
	$fridge = $queryPrepared->fetchAll();
}
?>

<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="card bg-color text-white pb-3 my-3" style="border-radius: 1rem;">
        <h3 class="text-center py-3">Mon Frigo</h3>

                <!--clean-->
        <div>
            <div class="overflow-auto " style="height : 480px">
            <?php
            foreach ($fridge as $ingredient) {
                echo 'eee<pre>';
                print_r($ingredient);
                echo '</pre>';
                echo $ingredient['QUANTITY'];
            echo '<div id="'.$ingredient['ID'].'"class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
                        <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-sm-6">
                                    <input checked="checked" type="checkbox" name="fcheckbox'.$ingredient['ID'].' value="'.$ingredient['QUANTITY'].'">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <p>'.$ingredient['NAME'].'</p>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 ">
                                    <input class="input-width text-dark" type="text" name="fquantity'.$ingredient['ID'].'" placeholder="quantité">
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
