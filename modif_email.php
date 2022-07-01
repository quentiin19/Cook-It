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
                    <a class="text-white" href="#" >Modifier mon email</a>
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
    <div class="col-lg-10 col-md-10 col-sm-10 bg-coleur">
    <?php
    if (isConnected()) {
			$pdo = connectDB();

			$queryPrepared = $pdo->prepare("SELECT * FROM USER where ID=:id");
			$queryPrepared->execute(["id" => $_SESSION["id"]]);
			$results = $queryPrepared->fetch();
    ?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie d-flex justify-content-center  ">
          <div class="container py-2  h-auto  ">
            <div class="row d-flex justify-content-center align-items-center h-100">
              
                <div class="card bg-color text-white" style="border-radius: 1rem;">
                  <div class="card-body  text-center">
                      <div class="mb-md-5 mt-md-4 pb-5">

                      <h2 class="fw-bold mb-2 text-uppercase">Problèmes de connexion ?</h2>
                      <p class="text-white-50 mb-5"> Entrez votre adresse mail et nous vous enverrons un lien pour récupérer votre compte.</p>

                        <div class="row">

                            <div class="col-lg-3 col-md-1 col-sm-0"></div>

                            <div class="col-lg-6 col-md-12 col-sm-12">

                                <form method="POST" action="">

                                    <input type="email" class="form-control" name="email" placeholder="Votre email" required="required"><br>
                                    
                                    <div class="row">

                                        <div class="col-lg-4 col-md-1 col-sm-0"></div>
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <input type="submit" class="btn btn-outline-light btn-lg py-2 " value="Envoyer">
                                    </div>
                                    
                            <div class="col-lg-4 col-md-1 col-sm-0"></div>

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

if(
!isset($_POST["email"]) ||
count($_POST)!=1
){

die("remplissez les deux champs SVP !");

}
}
?>

<?php include "template/footer.php";?>