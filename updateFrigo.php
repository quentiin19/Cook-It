<?php
session_start();
require "functions.php";

if (isConnected()) {
    //connexion à la bdd
    $pdo = ConnectDB();


    $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
    $queryPrepared->execute();
    $ingredients = $queryPrepared->fetchAll();

    //nous vérifions tous les ingrédients
    foreach ($ingredients as $ingredient) {
        //si la case de gauche est cochée
        if (isset($_POST['nfcheckbox' . $ingredient['ID']])) {

            //nous vérifions que l'ingredient n'est pas déjà dans le frigo
            $queryPrepared = $pdo->prepare("SELECT COUNT(ID_INGREDIENT) FROM FRIDGE where ID_USER = :id AND ID_INGREDIENT = :ingr;");
            $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID']]);
            $ingr_fridge = $queryPrepared->fetch();

            //si l'ingredient n'est pas dans dans le frigo de l'utilisateur
            if ($ingr_fridge[0] == 0) {
                //nous vérifions que la quantité est supérieure à zero
                if ($_POST['nfquantity' . $ingredient['ID']] > 0) {
                    //nous l'ajoutons à son frigo en bdd
                    $queryPrepared = $pdo->prepare("INSERT INTO FRIDGE VALUES (:id, :ingr, :quant);");
                    $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID'], 'quant' => $_POST['nfquantity' . $ingredient['ID']]]);
                }
            }

            //sinon si la case d'u ningrédient de droite est cochée
        } elseif (isset($_POST['fcheckbox' . $ingredient['ID']])) {
            //nous vérifions que la quantité est supérieure à zero
            if (($_POST['fquantity' . $ingredient['ID']]) > 0) {
                $queryPrepared = $pdo->prepare("UPDATE FRIDGE SET QUANTITY = :quantity WHERE ID_INGREDIENT = :ingr AND ID_USER = :id");
                $queryPrepared->execute(['quantity' => $_POST['fquantity' . $ingredient['ID']], 'ingr' => $ingredient['ID'], 'id' => $_SESSION['id']]);


                //sinon nous supprimons l'ingredient du frigo
            } else {
                $queryPrepared = $pdo->prepare("DELETE FROM FRIDGE WHERE ID_INGREDIENT = :ingr and ID_USER = :id;");
                $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID']]);
            }

            //si aucune case n'est cochée nous supprimons l'ingrédient du frigo dans tous les cas pour être sûr
        } else {
            $queryPrepared = $pdo->prepare("DELETE FROM FRIDGE WHERE ID_INGREDIENT = :ingr and ID_USER = :id;");
            $queryPrepared->execute(['id' => $_SESSION['id'], 'ingr' => $ingredient['ID']]);
        }
    }
}

header("Location: frigo.php?id=" . $_SESSION['id']);

//algo
// si nf et dans dans le frigo = erreuf
// si nf pas dans le frigo et checkbox = go dans le frigo
// si f et que <> checkbox = delete from ffridge
// si f et que checkbox = update 