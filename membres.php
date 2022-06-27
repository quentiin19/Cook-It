<?php include "template/header.php";?> 

<?php
    $pdo = connectDB();

// Condition  : si la personne est connecté elle ne se verra pas dans les membres ( on verifie si une variable de session existe)
if(isset($_SESSION['id'])){
    $afficher_membres = $pdo->prepare("SELECT * FROM USER WHERE id <> ?");
    $afficher_membres -> execute(array($_SESSION['id']));
}else{
    $afficher_membres = $pdo->prepare("SELECT * FROM USER");
    $afficher_membres -> execute();
}

?>

<div class="container">
    <div class="row">
        <?php
            foreach ($afficher_membres as $am){
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6"> 
            <div class="bg-light text-center ">
            <?= $am['PSEUDO'] ?> 
            </div>
        <?php
            }
        ?>
    </div>
</div>

?>