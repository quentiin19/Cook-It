<?php include "template/header.php";?> 

<?php
    $pdo = connectDB();

// Condition  : si la personne est connecté elle ne se verra pas dans les membres ( on verifie si une variable de GET existe)
if(isset($_GET['id'])){
    $abonnement = $pdo->prepare("SELECT * FROM USER WHERE ID IN (SELECT ID_SUBSCRIPTION FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :id) ORDER BY PSEUDO ASC;");
    $abonnement -> execute(['id' =>$_GET['id']]);
}else{
    echo 'Veillez Vous Connecter';
}

?>

<div class="container py-5">
    <div class="row">
        <?php
            foreach ($abonnement as $ab){
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6"> 
            <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                <div>
                    <img src="<?= $ab['PATH_AVATAR']?>" class="card-img-top cardh my-3"></img>
                </div>
                <div>
                    <?= $ab['PSEUDO'] ?>  
                </div>
                <a href="https://cookit.ovh/profil_membres.php?id=<?= $ab['ID'] ?>" class ="bg-light rounded my-3"> Voir le profil</a>
                
            </div>
        </div>
        <?php
            }
        ?>
    </div>
</div>

?>