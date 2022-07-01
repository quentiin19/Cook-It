<?php

include "template/header.php";

?>

<div class="row" height = "100%" >
    <div class="col-lg-2 col-md-2 col-sm-2 bg-color my-3 ml-5 arrondie ">
    <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="#" >Modifier mon profil</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5  py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/avatar.php?id=<?= $_SESSION['id']?>" >Modifier mon avatar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/modif_email.php?id=<?= $_SESSION['id']?>" >Modifier mon email</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-4 py-2 pl-2">
                    <a class="text-white" href="#" >Modifier mon mot de passe</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/test/fpdf/download_log.php?id=<?= $_SESSION['id'] ?>" >Télécharger mes logs</a>
                </div>
            </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 ">
    <?php
    if (isConnected()) {
			$pdo = connectDB();

			$queryPrepared = $pdo->prepare("SELECT * FROM USER where ID=:id");
			$queryPrepared->execute(["id" => $_SESSION["id"]]);
			$results = $queryPrepared->fetch();
    ?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie d-flex justify-content-center my-5 ">
          <div class="container py-2  h-auto  ">
            <div class="row d-flex justify-content-center align-items-center h-100">
              
                <div class="card bg-color text-white" style="border-radius: 1rem;">
                  <div class="card-body  text-center">
                      <div class="mb-md-5 mt-md-4 pb-5">

                      <h2 class="fw-bold mb-2 text-uppercase">MODIFIER VOTRE EMAIL</h2>
                      <p class="text-white-50 mb-5">N'oubliez pas de vérifier votre nouveau mail pour vous reconnecter.</p>

                        <div class="row">

                            <div class="col-lg-3 col-md-1 col-sm-0"></div>

                            <div class="col-lg-6 col-md-12 col-sm-12">

                                <form method="POST" action="changemail.php">

                                    <input type="email" class="form-control" name="emailold" placeholder="Votre email actuel" required="required"><br>

                                    <input type="email" class="form-control" name="emailnew" placeholder="Votre nouvel email" required="required"><br>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                            <input type="submit" class="btn btn-outline-light btn-lg py-2 " value="Envoyer">
                                        </div>
                                    

                        </div>
                                  </form>
                             </div>

                             <div class="col-lg-3 col-md-1 col-sm-0"></div>
                      
                        </div>



                  </div>
                </div>
              </div>
            </div>
</div>
</div>
</div>
<?php

}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <?php // include "template/footer.php";?>