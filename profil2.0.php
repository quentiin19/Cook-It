<?php

include 'template/header.php';
?>


<div class="row" height = "100%" >
    <div class="col-lg-2 col-md-2 col-sm-2 bg-color my-3 ml-5 arrondie ">
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a href="#" >Modifier mon profil</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5  py-2 pl-2">
                    <a href="#" >Modifier mon avatar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a href="#" >Modifier mon email</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-4 py-2 pl-2">
                    <a href="#" >Modifier mon mot de passe</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a href="#" >Télécharger mes logs</a>
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
			<div class="col-lg-12 col-md-12 col-sm-12 my-3 mr-3 h-auto arrondie d-flex justify-content-center  ">
					  <div class="container   h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

					            <div class="mb-md-5 mt-md-4 pb-5">
								<div class="row">
									<div class="col-lg-12 pb-3" >	
										<?php //include "avatar/avatar.php"; ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 pb-3" >	
										<h2> Mes Informations </h2>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2 col-md-0 col-sm-0"></div>
									<div class="col-lg-8 col-md-12 col-sm-12 bg-color arrondie">
									<!-- Information du Compte -->
										<form method="POST" action="UpdateUser.php">
											Votre prénom :<input type="text" class="form-control" name="firstname" placeholder="Votre prénom" value="<?=$results["FIRSTNAME"]?>"><br>
											Votre nom :<input type="text" class="form-control" name="lastname" placeholder="Votre nom" value=" <?=$results["LASTNAME"]?>"><br>
											Votre pseudo :<input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo"  required="required" value=" <?=$results["PSEUDO"]?>"><br>
											Votre Descriptin :<textarea row=3 type="text" class="form-control" name="description" placeholder="Votre description"  required="required" value=" <?=$results["DESCRIPTION_PROFIL"]?>"></textarea><br>
											<h3 class="py-3"> Confirmez en rentrant votre mot de passe </h3>
											<input type="password" class="form-control" name="password" placeholder="mot de passe"  required="required"><br>
											<?php
											echo '<a href="pwdmodif.php?id="'.$_SESSION["id"].'>Modifier votre Mot de passe</a><br>';
											?>
											<input  type="submit" class=" ml-3 mt-5 btn btn-light btn-lg py-2 " value="Modifier">
										</form>
									</div>
									<div class="col-lg-2 col-md-0 col-sm-0"></div>

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


<!-- PAGINATION --> 

