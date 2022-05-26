<?php include "template/header.php";?>
<?php
if (isConnected()) {
			$pdo = connectDB();

			$queryPrepared = $pdo->prepare("SELECT * FROM USER where ID=:id");
			$queryPrepared->execute(["id" => $_SESSION["id"]]);
			$results = $queryPrepared->fetch();
?>
<div class="row">

			<div class="col-lg-2 col-md-1 col-sm-0"></div>

			<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
					  <div class="container py-2  h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

					            <div class="mb-md-5 mt-md-4 pb-5">
								<div class="row">
									<div class="col-lg-12 mb-3">
										<h2> Personnaliser mon avatar </h2>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 pb-3" >	
										<?php include "avatar/avatar.php"; ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 pb-3" >	
										<h2> Mes Informations </h2>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3 col-md-0 col-sm-0"></div>
									<div class="col-lg-6 col-md-12 col-sm-12">
									<!-- Information du Compte -->
										<form method="POST" action="">
											<input type="text" class="form-control" name="firstname" placeholder="Votre prénom" value="<?=$results["FIRSTNAME"]?>"><br>
											<input type="text" class="form-control" name="lastname" placeholder="Votre nom" value=" <?=$results["LASTNAME"]?>"><br>
											<input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo"  required="required" value=" <?=$results["PSEUDO"]?>"><br>
					    			</div>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="">Votre Prénom</span>
										</div>
										<input type="text" class="form-control" name="firstname"  value="<?=$results["FIRSTNAME"]?>"><br>
										</div>
									<div class="col-lg-3 col-md-0 col-sm-0"></div>
									
									<?php 
										
												
														 
										echo'<td>'.$results["ID"].'</td>';
										echo'<td>'.$results["LASTNAME"].'</td>';
										echo'<td>'.$results["FIRSTNAME"].'</td>';
										echo'<td>'.$results["PSEUDO"].'</td>';
										echo'<td>'.$results["MAIL"].'</td>';

																?>

					            </div>
					           </div>
					        </div>
					    </div>
					  </div>
			</div>
			<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>


<?php include "template/footer.php";?>
<?php
}
?>