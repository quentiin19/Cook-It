<?php include "template/header.php";?>

<?php	


if (isConnected() == $_SESSION['id']){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT *  FROM RECIPES WHERE ID_RECIPE = :idr;");
	$queryPrepared->execute(["idr" => $_GET['id']]);
	$resultR = $queryPrepared->fetch();

	$queryPrepared = $pdo->prepare("SELECT *  FROM NEED WHERE ID_RECIPE = :id;");
	$queryPrepared->execute(["id" => $_GET['id']]);
	$resultN = $queryPrepared->fetchAll();

	$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
	$queryPrepared->execute();
	$allIngredient = $queryPrepared->fetchAll();
}




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
							<h2> Recette </h2>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-md-0 col-sm-0"></div>
						<div class="col-lg-8 col-md-12 col-sm-12 bg-color arrondie">
							<div>
								<img src="<?= $resultR['PICTURE_PATH']?>" ></img>						
							</div>
						<!-- Affichage recette -->
							<form method="POST" action="modifRecette.php">
								<div class ="py-3">
									Title :<input type="text" class="form-control py-4" name="title" placeholder="Votre recette" value="<?=$resultR["TITLE"]?>"><br>
                                    <div class="col-lg-6 col-md-6 col-sm-6 pl-2">
                                                <h3 class="text-center py-3">Votre Recette </h3>
                                                <textarea class="form-control my-3" name="recette_description"
                                                    rows="20" value="20"><?=$resultR["DESCRIPTION"]?></textarea>
                                    </div>                                    
                                    <div class="col-lg-4 col-md-4 col-sm-4">
									<h4>Ingredients :</h4> <br>

											<!--clean-->
											<div>
												<div class="overflow-auto " style="height : 300px">
												<?php
												foreach($allIngredient as $ingredient){
													foreach($resultN as $key => $need){
														if($ingredient['ID'] == $need['ID_INGREDIENT']){
															echo '<div class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
																	<div class="row align-items-center">
																		<div class="col-lg-1 col-md-1 col-sm-6">
																			<input checked="checked" type="checkbox" name="checkbox'.$ingredient['ID'].'">
																		</div>
																		<div class="col-lg-3 col-md-3 col-sm-6">
																			<img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
																		</div>
																		<div class="col-lg-3 col-md-3 col-sm-3">
																			<p>'.$ingredient['NAME'].'</p>
																		</div>
																		<div class="col-lg-3 col-md-2 col-sm-6 ">
																			<input class="input-width" type="text" name="quantity'.$ingredient['ID'].'" value='.$need['QUANTITY'].' placeholder="quantité">
																		</div>
																		<div class="col-lg-2 col-md-3 col-sm-3">
																			'.$ingredient['UNIT'].'
																		</div>		
																	</div>
																</div>';
														}else{
															echo '<div class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
																<div class="row align-items-center">
																	<div class="col-lg-1 col-md-1 col-sm-6">
																		<input type="checkbox" name="checkbox'.$ingredient['ID'].'">
																	</div>
																	<div class="col-lg-3 col-md-3 col-sm-6">
																		<img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
																	</div>
																	<div class="col-lg-3 col-md-3 col-sm-3">
																		<p>'.$ingredient['NAME'].'</p>
																	</div>
																	<div class="col-lg-3 col-md-2 col-sm-6 ">
																		<input class="input-width" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
																	</div>
																	<div class="col-lg-2 col-md-3 col-sm-3">
																		'.$ingredient['UNIT'].'
																	</div>		
																</div>
															</div>';
														}
													}
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<input  type="submit" class=" ml-3 mt-5 btn btn-light btn-lg py-2 " value="Modifier">
							</form>
						
							<!--fin form-->




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