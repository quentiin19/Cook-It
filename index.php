<?php
include "template/header.php";

if (isConnected()) {
  echo '<p id="id-user" hidden="hidden">' . $_SESSION['id'] . '</p>';
  echo '<p id="token-user" hidden="hidden">' . $_SESSION['token'] . '</p>';
}

if (!isset($_GET['p'])) {
  header("Location: index.php?p=1");
}

$p = $_GET['p'];
?>

<div class="d-flex justify-content-start my-3">
  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
    Comment ça marche ?
  </button>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Comment ça marche ?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Bienvenue sur CookIt, le site de cuisine pas comme les autres, </br>
        Sur cet incroyable site, vous pourrez créer vos recettes favorites et les partagées au monde entier.</br>
        Votre Frigo est presque vide, vous ne savez pas quoi cuisiner ? </br>
        Pas de panique , sélectionnez les ingrédients et la quantité qu'il vous reste dans la section "frigo",
        et nous vous proposerons des recettes.</br>
        Si un utilisateur publie du contenu qui vous plait vous pouvez le suivre grâce au bouton "S'abonner".</br>
        N'oubliez pas d'ajouter une description qui vous correspond à votre profil.</br>
        La particularité de Cook'it est le systeme de "match" ! </br>
        Lorsque qu'une personne vous interesse ( vous avez les memes gouts cullinaires, et que sa description vous plait ),
        Il suffit de cliquer sur "match", sur son profil. </br>
        Si les 2 personnes match alors une messagerie
        est débloquer pour faire plus ample connaissance et pourquoi trouver votre ame-soeur.
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
      </div>

    </div>
  </div>
</div>




<div>
  <div class="d-flex justify-content-center my-3">
    <input type="text" id="search-bar-recipe" placeholder="rechercher une recette" class="text-center">
  </div>
  <div id="recettes"></div>

  <div id="recettes-php">

    <?php
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT ID_RECIPE, PICTURE_PATH, TITLE, ID_CREATOR, PSEUDO FROM RECIPES, USER WHERE USER.ID = RECIPES.ID_CREATOR ORDER BY RECIPES.ID_RECIPE DESC;");
    $queryPrepared->execute();
    $recipes = $queryPrepared->fetchAll();
    $pmax = ceil(count($recipes) / 20); //Calcule le nombre de pages totales


    if ((($p - 1) * 20 + 19) > count($recipes) - 1) {
      $q = count($recipes);
    } else {
      $q = ($p - 1) * 20 + 20;
    }

    for ($i = (($p - 1) * 20); $i < $q; $i++) {
      echo '<div class="col-lg-3 col-md-4 col-sm-1 py-3">
                    <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                        <a href="https://cookit.ovh/recette.php?id=' . $recipes[$i]['ID_RECIPE'] . '">
                        <img src="' . $recipes[$i]['PICTURE_PATH'] . '" class="card-img-top cardh"> </img>
                        <div class="card-body text-center arrondie">
                                    <h4 class="text-white">' . $recipes[$i]['TITLE'] . '</h4>
                                    <a href="https://cookit.ovh/profil.php?id=' . $recipes[$i]['ID_CREATOR'] . '" class=" btn btn-secondary" style="height : 30px"><p>Créé par ' . $recipes[$i]['PSEUDO'] . '</p></a>
                        </div>';
      if (isAdmin()) {
        echo '<div class="text-right">
                                    <a href="https://cookit.ovh/delRecette.php?id=' . $recipes[$i]['ID_RECIPE'] . '"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
                                </div>';
      }

      echo '</a>        
                    </div>
                </div>';
    }
    ?>

  </div>
</div>
<!-- PAGINATION -->
<div id="next-prev" class="row">
  <div class="d-flex justify-content-center mb-5 ">

    <button type="button" class="btn btn-secondary mx-3 text-white"><a class="text-white" href="
                    <?php
                    if ($p == 1) {
                      echo '#';
                    } else {
                      echo 'https://cookit.ovh/index.php?p=' . ($p - 1);
                    }
                    ?>">Previous</a></button>

    <p class="my-3"> Pages : <?= $p . '/' . $pmax ?> </p>


    <button type="button" class="btn btn-secondary mx-3 "><a class="text-white" href="
                    <?php
                    if ($p == $pmax) {
                      echo '#';
                    } else {
                      echo 'https://cookit.ovh/index.php?p=' . ($p + 1);
                    }
                    ?>">Next</a></button>


  </div>
</div>






<script src="ressources/js/ajax_recette.js"></script>

<?php include "template/footer.php"; ?>



<!-- PAGINATION -->