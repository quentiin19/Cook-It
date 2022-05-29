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
											<nav id="navbar-example2" class="navbar navbar-light bg-light">
											<a class="navbar-brand" href="#">Navbar</a>
											<ul class="nav nav-pills">
												<li class="nav-item">
												<a class="nav-link" href="#fat">@fat</a>
												</li>
												<li class="nav-item">
												<a class="nav-link" href="#mdo">@mdo</a>
												</li>
												<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#one">one</a>
													<a class="dropdown-item" href="#two">two</a>
													<div role="separator" class="dropdown-divider"></div>
													<a class="dropdown-item" href="#three">three</a>
												</div>
												</li>
											</ul>
											</nav>
											<div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
											<h4 id="fat">@fat</h4>
											<p>...</p>
											<h4 id="mdo">@mdo</h4>
											<p>...</p>
											<h4 id="one">one</h4>
											<p>...</p>
											<h4 id="two">two</h4>
											<p>...</p>
											<h4 id="three">three</h4>
											<p>...</p>
											</div>
											</div>
										<div class="row">
											<div class="col-lg-6 col-md-6">
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
	empty($_POST["temps"]) ||
	empty($_POST["recette_description"]) ||
	empty($_POST["fichier"])||
	count($_POST)!=4
){

	die("remplissez les champs requis");

}else{
	echo "TEST";
}


$recette = $_POST["recette"];
$temps = $_POST["temps"];
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