<?php
session_start();
require "functions.php";
$pdo = ConnectDB();

if (isConnected()){
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';


    $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
    $queryPrepared->execute();
    $ingredients = $queryPrepared->fetchAll();

    foreach($ingredients as $ingredient){
        if(isset($_POST['nfcheckbox'.$ingredient['ID']])){
            // il a coché la check
            $queryPrepared = $pdo->prepare("SELECT COUNT(ID_INGREDIENT) FROM FRIDGE where ID_USER = :id AND ID_INGREDIENT = :ingr;");
            $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID']]);
            $ingr_fridge = $queryPrepared->fetch();

            if ($ingr_fridge[0] == 0){
                //Pas dans le frigo
                $queryPrepared = $pdo->prepare("INSERT INTO FRIDGE VALUES (:id, :ingr, :quant);");
                $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID'], 'quant' => $_POST['nfquantity'.$ingredient['ID']]]);
            }
        }elseif(isset($_POST['fcheckbox'.$ingredient['ID']])){

            if(($_POST['fquantity'.$ingredient['ID']]) > 0) {
                    $queryPrepared = $pdo -> prepare("UPDATE FRIDGE SET QUANTITY = :quantity WHERE ID_INGREDIENT = :ingr AND ID_USER = :id");
                    $queryPrepared->execute(['quantity' => $_POST['fquantity'.$ingredient['ID']], 'ingr' =>  $ingredient['ID'], 'id' => $_SESSION[['id']]]);
                }

        }else{
            $queryPrepared = $pdo-> prepare("DELETE FROM FRIDGE WHERE ID_INGREDIENT = :ingr and ID_USER = :id;");
            $queryPrepared -> execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID']]);
        }

            // if ($_POST['fquantity'.$ingredient['ID']]) != 0 {
            //     $queryPrepared = $pdo -> prepare("UPDATE FRIDGE SET QUANTITY = :quantity WHERE ID_INGREDIENT = :id");
            //     $queryPrepared =execute(['quantity' => $_POST['ffquantity'.$ingredient['ID']], 'id' =>  $ingredient['ID']])
            // }
        
    }
}

//header("Location: frigo.php?id=".$_SESSION['id']);
// si nf et dans dans le frigo = erreuf
// si nf pas dans le frigo et checkbox = go dans le frigo
// si f et que <> checkbox = delete from ffridge
// si f et que checkbox = update 