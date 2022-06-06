<?php   
		include "template/header.php";
?>
	
<div class="row">
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
	<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
		<div class="container py-2  h-auto  ">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="card bg-color text-white" style="border-radius: 1rem;">
					<div class="card-body  text-center">
						<div class="mb-md-5 mt-md-4 pb-5">
							<h2 class="fw-bold mb-2 text-uppercase">CREER UNE RECETTE</h2>
							<p class="text-white-50 mb-5">Partager vos recettes préférées</p>

							<div class="row">
								<div class="col-lg-12 col-md-12 bg-color arrondie py-5 ">
									<form method="POST" action="./insertrecette.php">

										<input type="text" class="form-control my-3" name="recette" placeholder="Nom de la recette" required="required"><br>
										<div class="row">
											<h3 class="text-center py-3">Ajouter une image à ma recette </h3>
												<input type="file" name="fichier" required="required"> <br>	
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 input-group">
												<textarea class="form-control" aria-label="With textarea" placeholder="Votre Recette" name="recette_description" required="required"></textarea>
											</div>
										</div>
										<div class="row">
											<h3 class="text-center py-3">Ajouter les ingrédients </h3>
										</div>

										<?php
										$pdo = connectDB();

											$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
											$queryPrepared->execute();
											$results = $queryPrepared->fetchAll();

											foreach ($results as $key => $ingredient) { ?>
											<div class="row">
											<div class="col-lg-2 col-md-1 col-sm-0"></div>
											<div class="col-lg-8 col-md-10 col-sm-12 background-body arrondie my-2">
												<div class="row align-items-center">
														<div class="col-lg-1 col-md-1 col-sm-1">
															<input  type="checkbox" name=<?php echo "checkbox".$ingredient['ID']?>">
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3">
															<img src="<?= $ingredient['PICTURE_PATH']?>" height ="70vh" width="70vw"/>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3">
															<p ><?= $ingredient['NAME']?></p>
														</div>
														<div class="col-lg-3 col-md-2 col-sm-2 input-width">
															<input type="text" name="quantity<?php echo $ingredient['ID']?>" placeholder="quantité">
														</div>
														<div class="col-lg-2 col-md-3 col-sm-3">
															<?= $ingredient['UNIT']?>
														</div>		
												</div>
											</div>
											<div class="col-lg-2 col-md-1 col-sm-0"></div>
										</div>
										<?php	}
											?>
										
										<div class="row">
											<div class="col-lg-12 col-md-12">
													<button class="btn btn-outline-light btn-lg px-2 " type="submit">Envoyer</button>
											</div>
										</div>
									</form>
								</div>
							</div>
		    			</div>
					</div>
				</div>
			</div>
		</div>
	</div>		    	
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>
<?php include "template/footer.php";?>



