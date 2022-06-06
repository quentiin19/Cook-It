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
									<form method="POST" action="">
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
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
													<h4 id="scrollspyHeading1">First heading</h4>
													<p>...</p>
													<h4 id="scrollspyHeading2">Second heading</h4>
													<p>...</p>
													<h4 id="scrollspyHeading3">Third heading</h4>
													<p>...</p>
													<h4 id="scrollspyHeading4">Fourth heading</h4>
													<p>...</p>
													<h4 id="scrollspyHeading5">Fifth heading</h4>
													<p>...</p>
												</div>
											</div>
										</div>
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
	<div class="col-lg-2"></div>
</div>
<?php include "template/footer.php";?>



<?php
if(
	empty($_POST["recette"]) || 
	empty($_POST["recette_description"]) ||
	empty($_POST["fichier"])||
	count($_POST)!=3
){

	die("remplissez les champs requis");

}else{
	echo "TEST";
}


$recette = $_POST["recette"];
$recette_description = $_POST["recette_description"];
$fichier = $_POST["fichier"];

$queryPrepared = $pdo->prepare("INSERT INTO RECIPES (        
ID_CREATOR, 
TITLE,      
DESCRIPTION ) 
VALUES (:idcreator, :title, :recettedesc);");



$queryPrepared->execute([
						"idcreator"=>$_SESSION['ID'],
						"title"=>$recette,
						"recettedesc"=>$recette_description
]);


?>