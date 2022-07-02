<?php include "template/header.php";?>
<?php
if (isConnected()) {
?>
<div class="row" height = "100%" >
    <div class="col-lg-2 col-md-2 col-sm-2 bg-color my-3 ml-5 arrondie ">
<div class="row">
                <div class="col-lg-12 my-5 py-2 pl-2">
                    <a class="text-white" href="https://cookit.ovh/modif_profil.php?id=<?= $_SESSION['id']?>" >Modifier mon profil</a>
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
    <div class="col-lg-10 col-md-10 col-sm-10 bg-coleur">
<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie d-flex justify-content-center  ">
					  <div class="container py-2  h-auto  ">
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
									<div class="col-lg-2 col-md-0 col-sm-0"></div>
									<div class="col-lg-8 col-md-12 col-sm-12 bg-color arrondie">
										<form method="POST" action="UpdatePWD.php">
											<h2 class="py-3"> Modifier mon mot de passe </h2>
											<input type="password" class="form-control" name="oldpassword" placeholder="ancien mot de passe"  required="required"><br>
											<input type="password" class="form-control" name="password" placeholder="nouveau mot de passe" required="required"><br>
											<input type="password" class="form-control" name="passwordConfirm" placeholder="confirmation" required="required"><br>
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
</div>

<?php include "template/footer.php";?>
<?php
}
?>