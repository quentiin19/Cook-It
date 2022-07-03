<?php 
include "template/header.php";


if (isConnected() != $_SESSION['id']){
    header("Location: login.php");
}else{
    //connexion à la bdd
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID IN (SELECT ID_MATCHER FROM MATCHS WHERE STATUS = 1 AND ID_MATCH = :id);");
	$queryPrepared->execute(["id" => $_SESSION['id']]);
	$friends = $queryPrepared->fetchAll();
}
?>

<div class="container py-5">
    <div class="row">
        <?php
            foreach ($friends as $friend){
                $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :id AND ID_MATCH = :id_sender;");
                $queryPrepared->execute(['id'=>$_SESSION['id'], 'id_sender'=>$friend['ID']]);
                $result = $queryPrepared->fetch();

                if($result[0] == 0){
                    echo '<div class="col-lg-3 col-md-4 col-sm-6"> 
                            <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                                <img src="'.$friend['PATH_AVATAR'].'">
                                <div>'.$friend['PSEUDO'].'</div>
                                <button type="button" class="btn btn"><a href="https://cookit.ovh/social-action.php?id='.$friend['ID'].'&action=match" class ="bg-light rounded my-3"> Accepter</a></button>
                                <button type="button" class="btn btn"><a href="https://cookit.ovh/social-action.php?id='.$friend['ID'].'&action=rmatch" class ="bg-light rounded my-3"> Refuser</a></button>
                            </div>
                        </div>';

                }
        
            }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>