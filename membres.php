<?php include "template/header.php";?> 

<?php
    $pdo = connectDB();

// Condition  : si la personne est connecté elle ne se verra pas dans les membres ( on verifie si une variable de session existe)
if(isset($_SESSION['id'])){
    $afficher_membres = $pdo->prepare("SELECT * FROM USER WHERE id <> :id");
    $afficher_membres -> execute(['id' =>$_SESSION['id']]);
}else{
    $afficher_membres = $pdo->prepare("SELECT * FROM USER");
    $afficher_membres -> execute();
}

?>

<div class="container py-5">
    <div class="row">
        <?php
            foreach ($afficher_membres as $am){
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6"> 
            <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                <div>
                    <img src="<?= $am['PATH_AVATAR']?>" class="card-img-top cardh"></img>
                </div>
                <div>
                    <?= $am['PSEUDO'] ?>  
                </div>
                <a href="https://cookit.ovh/profil_membres.php?id=<?= $am['ID'] ?>" class ="bg-color text-white  rounded"> Voir le profil</a>
                
            </div>
        </div>
        <?php
            }
        ?>
    </div>
</div>

?>