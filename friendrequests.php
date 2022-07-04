<?php
include "template/header.php";


if (isConnected() != $_SESSION['id']) {
    header("Location: login.php");
} else {
    //connexion à la bdd
    $pdo = connectDB();

    //récupération de tous les user qui ont matché
    $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID IN (SELECT ID_MATCHER FROM MATCHS WHERE STATUS = 1 AND ID_MATCH = :id);");
    $queryPrepared->execute(["id" => $_SESSION['id']]);
    $matchs = $queryPrepared->fetchAll();
}
?>

<div class="container py-5">
    <div class="row">
        <?php
        foreach ($matchs as $match) {
            $queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :id AND ID_MATCH = :id_sender;");
            $queryPrepared->execute(['id' => $_SESSION['id'], 'id_sender' => $match['ID']]);
            $result = $queryPrepared->fetch();

            //si nous n'avons pas encore matché avec cette personne
            if (isset($result[0])) {
                if ($result[0] == 0) {
                    echo '<div class="col-lg-3 col-md-4 col-sm-6"> 
                                <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                                    <img src="' . $matchs['PATH_AVATAR'] . '">
                                    <div>' . $matchs['PSEUDO'] . '</div>
                                    <button type="button" class="btn btn"><a href="https://cookit.ovh/social-action.php?id=' . $friend['ID'] . '&action=match" class ="bg-light rounded my-3"> Accepter</a></button>
                                    <button type="button" class="btn btn"><a href="https://cookit.ovh/social-action.php?id=' . $friend['ID'] . '&action=rmatch" class ="bg-light rounded my-3"> Refuser</a></button>
                                </div>
                            </div>';
                }
            }
        }
        ?>
    </div>
</div>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
<?php include "template/footer.php"; ?>