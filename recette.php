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
							<h2 class="fw-bold mb-2 text-uppercase"><?= $recipe['TITLE']?></h2>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-md-12">
									<img src="<?=$recipe['PICTURE_PATH']?>">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8">
									<h4>Recette :</h4><br>
									<p><?= $recipe['DESCRIPTION']?></p>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<h4>Ingredients :</h4> <br>
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
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>
















<?php include "template/footer.php";?>