<?php include "template/header.php";

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id"=>$_GET['id']]);
$recipe = $queryPrepared->fetch();


$queryPrepared = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id"=>$_GET['id']]);
$needs = $queryPrepared->fetchAll();


$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
$queryPrepared->execute(["id"=>$_GET['id']]);
$ingredients = $queryPrepared->fetchAll();




?>






<div class="row">

	<div class="col-lg-2 col-md-1 col-sm-0"></div>
	<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
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
									<button type="button" class="btn btn-default px-3"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i></button>
									<button type="button" class="btn btn-default px-3"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button>
									<button type="button" class="btn btn-default px-3"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
								</div>
							</div>

						<!-- PHOTO + INGREDIENTS (DOSES) -->
							<div class="row py-5">
								<div class="col-lg-6 col-md-6 col-md-6">
									<div class="card ">
										<img src="<?=$recipe['PICTURE_PATH']?>" class="card-img-top cardh">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="overflow-auto " style="height : 300px">
										<table>
										<?php
											foreach ($ingredients as $key => $ingredient) {
												
												echo '	<tr>
															<td><img src="'.$ingredient['PICTURE_PATH'].'" height="70vh" width="70vw""></td>
															<td>'.$ingredient['NAME'].'</td>
															<td>'.$needs[$key]['QUANTITY'].'</td>
															<td>'.$ingredient['UNIT'].'</td>
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
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>
















<?php include "template/footer.php";?>