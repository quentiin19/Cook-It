<?php include "template/header.php";?> 


<?php
    $pdo = connectDB();

// Condition  : si la personne est connecté elle ne se verra pas dans les membres ( on verifie si une variable de SESSIO$_SESSION existe)
if($_GET['display']==1){

    $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID IN (SELECT ID_SUBSCRIPTION FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :id AND STATUS=1) ORDER BY PSEUDO ASC;");
    $queryPrepared -> execute(['id' =>$_GET['id']]);
    $abonnement = $queryPrepared -> fetchAll();


?>
<h1 class="text-center my-3">Abonnements</h1>
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
                <a href="https://cookit.ovh/profil.php?id=<?= $ab['ID'] ?>" class ="bg-light rounded my-3"> Voir le profil</a>
                
            </div>
        </div>
        <?php
            }
    echo'    
    </div>
</div>';
}elseif($_GET['display']==2){
?>

<?php
// Condition  : si la personne est connecté elle ne se verra pas dans les membres ( on verifie si une variable de SESSIO$_SESSION existe)

    $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID IN (SELECT ID_SUBSCRIBER FROM SUBSCRIPTION WHERE ID_SUBSCRIPTION = :id) ORDER BY PSEUDO ASC;");
    $queryPrepared -> execute(['id' =>$_GET['id']]);
    $abonnement = $queryPrepared -> fetchAll();


?>
<h1 class="text-center my-3">Abonnés</h1>
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
                <a href="https://cookit.ovh/profil.php?id=<?= $ab['ID'] ?>" class ="bg-light rounded my-3"> Voir le profil</a>
                
            </div>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<?php
}
?>