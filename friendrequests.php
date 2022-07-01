<?php 
include "template/header.php";


if (isConnected() == $_SESSION['id']){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT *  FROM SUBSCRIPTION WHERE ID_SUBSCRIPTION = :idstion AND STATUS = 0;");
	$queryPrepared->execute(["idstion" => $_GET['id']]);
	$friends = $queryPrepared->fetchAll();

}
echo'<pre>';
print_r($friends);
echo'</pre>';

echo'
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">';
foreach ($friends as $friend){
    echo '
            <div class="col-lg-4 col-md-4 col-sm-1 py-3">
                <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                    <a href="https://cookit.ovh/profil.php?id='.$friend[0].'"></a>        
                </div>
            </div>';
}
echo '
    </div>
    <div class="col-lg-2"></div>
</div>';


?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>