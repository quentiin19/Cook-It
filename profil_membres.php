<?php include "template/header.php";?>

<?php	



	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID=:id;");
	$queryPrepared->execute(["id"=>$_GET['id']]);
	$results = $queryPrepared->fetch();


?>
<div class="row">


	<div class="d-flex justify-content-center h-auto arrondie  ">
		<div class="container py-2  h-auto  ">
			<div class="row d-flex justify-content-center align-items-center h-100">
					
				<div class="card bg-color text-white" style="border-radius: 1rem;">
					<div class="card-body  text-center">

					<div class="mb-md-5 mt-md-4 pb-5">
					<div class="row">
						<div class="col-lg-12 pb-3" >	
							<h2> Informations du compte </h2>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-0 col-sm-0"></div>
						<div class="col-lg-8 col-md-12 col-sm-12 bg-color arrondie">
							<div>
								<img src="<?= $results['PATH_AVATAR']?>" ></img>						
							</div>
						<!-- Information du Compte -->
							<form method="POST" action="UpdateUser.php">
								<div class ="py-3">
									Prénom :<input type="text" class="form-control py-4" name="firstname" placeholder="Votre prénom" value="<?=$results["FIRSTNAME"]?>"><br>
									Nom :<input type="text" class="form-control" name="lastname" placeholder="Votre nom" value=" <?=$results["LASTNAME"]?>"><br>
									Pseudo :<input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo"  required="required" value=" <?=$results["PSEUDO"]?>"><br>
									<input  type="hidden" name="id" value="<?= echo $_GET['id'] ?>">
									<input  type="submit" class=" ml-3 mt-5 btn btn-light btn-lg py-2 " value="Modifier">								
								</div>
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


<?php include "template/footer.php";?>
