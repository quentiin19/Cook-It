<?php include "template/header.php";

$pdo = connectDB();
//récupération de la recette
$queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id"=>$_GET['id']]);
$recipe = $queryPrepared->fetch();

//récupération des ingrédients nécessaire pour la recette
$queryPrepared = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id"=>$_GET['id']]);
$needs = $queryPrepared->fetchAll();

//récupération des informations des ingrédients
$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
$queryPrepared->execute(["id"=>$_GET['id']]);
$ingredients = $queryPrepared->fetchAll();

//récupération de l'info si l'utilisateur à enregistré la recette actuelle (COUNT = 0 -> non
//																			COUNT = 1 -> oui)
$queryPrepared = $pdo->prepare("SELECT COUNT(ID_USER) FROM RECIPES_SAVED WHERE ID_RECIPE = :id_recipe AND ID_USER = :id_user;");
$queryPrepared->execute(["id_recipe"=>$_GET['id'], "id_user"=>isConnected()]);
$saved = $queryPrepared->fetch();

?>






<div class="row ">
	<div class="col-lg-12 col-md-12 col-sm-12 d-flex h-auto arrondie justify-content-center ">
		<div class="container py-2  h-auto  ">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="card bg-color text-white" style="border-radius: 1rem;">
					<div class="card-body  text-center">
						<div class="mb-md-5 mt-md-4 pb-5">
						<!-- TITRE + UP&DOWN VOTES + ENREGISTREMENT + MODIF + SUPPRESSION -->
							<div class="row">
								<div class="col-lg-3">
									<div class="btn-group-vertical" role="" aria-label="Groupe de boutons en colonne">
										<button type="button" id='upvote-1' class="btn btn-secondary"><i class="glyphicon glyphicon-menu-up" aria-hidden="true"></i></button>

										<button type="button" id='downvote-1' class="btn btn-secondary"><i class="glyphicon glyphicon-menu-down" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="col-lg-6">
									<h2 class="fw-bold mb-2 text-uppercase"><?= $recipe['TITLE']?></h2>
								</div>
								<div class="col-lg-3">

									<?php
									if(isConnected()){
										if ($saved['0'] == 1) {
											echo '<a href="https://cookit.ovh/saveRecipe.php?id_recipe='.$_GET['id'].'"><button type="button" class="btn btn-success px-3"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i></button></a>';
										}else{
											echo '<a href="https://cookit.ovh/saveRecipe.php?id_recipe='.$_GET['id'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i></button></a>';
										}
										
										if($recipe['ID_CREATOR'] == isConnected() || isAdmin()){
											echo '
											<a href="https://cookit.ovh/modifRecette.php?id='.$_GET['id'].'"><button type="button" class="btn btn-primary px-3"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>
											<a href="https://cookit.ovh/delRecette.php?id='.$_GET['id'].'"><button type="button" class="btn btn-danger px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
										';
										}
									}
									
									
									?>

								</div>
							</div>

						<!-- PHOTO + INGREDIENTS (DOSES) -->
							<div class="row py-5">
								<div class="col-lg-6 col-md-6 col-md-6">
									<div class="card bg-color py-3 ">
										<img src="<?=$recipe['PICTURE_PATH']?>" class="card-img-top cardh">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 ">
									<h3 class="text-center">Ingrédients</h3>
                                    <div class="overflow-auto" style="height : 100%">
										<table>
										<?php
											foreach ($ingredients as $key => $ingredient) {
												echo '
														<tr>															
																<td class="px-1"><img src="'.$ingredient['PICTURE_PATH'].'" height="70vh" width="70vw""></td>
																<td class="px-1">'.$ingredient['NAME'].'</td>
																<td class="px-1">'.$needs[$key]['QUANTITY'].'</td>
																<td class="px-1">'.$ingredient['UNIT'].'</td>
															
														</tr>';

											}
										?>
										</table>
									</div>
								</div>
							</div>
							<!-- RECETTE -->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<h4>Recette :</h4><br>
									<p><?= $recipe['DESCRIPTION']?></p>
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