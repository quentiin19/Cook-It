<?php include "template/header.php";?>

<?php	


if (isConnected() == $_SESSION['id']){
$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT *  FROM RECIPES WHERE ID_RECIPE = :idr;");
$queryPrepared->execute(["idr" => $_GET['id']]);
echo "1";
$resultR = $queryPrepared->fetch();

$queryPrepared = $pdo->prepare("SELECT *  FROM NEED WHERE ID_RECIPE = :id;");
$queryPrepared->execute(["id" => $_GET['id']]);
$resultN = $queryPrepared->fetch();
}

$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
$queryPrepared->execute(["id"=>$_GET['id']]);
$ingredients = $queryPrepared->fetchAll();


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
								<img src="<?= $results['PICTURE_PATH']?>" ></img>						
							</div>
						<!-- Affichage recette -->
							<form method="POST" action="modifRecette.php">
								<div class ="py-3">
									Title :<input type="text" class="form-control py-4" name="title" placeholder="Votre recette" value="<?=$resultR["TITLE"]?>"><br>
									Description :<input type="text" class="form-control" name="description" placeholder="Votre description" value=" <?=$resultR["DESCRIPTION"]?>"><br>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
									<h4>Ingredients :</h4> <br>
									<table>
									<?php
										foreach ($ingredients as $key => $ingredient) {
											
											echo '	<tr>
														<td><img src="'.$ingredient['PICTURE_PATH'].'" height="70vh" width="70vw""></td>
														<td>'.$ingredient['NAME'].'</td>
														<td>'.$resultN[$key]['QUANTITY'].'</td>
														<td>'.$resultN['UNIT'].'</td>
													</tr>';
										}
										?>
									</table>
								</div>									
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