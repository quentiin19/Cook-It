<?php include "template/header.php";?>
	
<div class="row">

			<div class="col-lg-2 col-md-1 col-sm-0"></div>

			<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
					  <div class="container py-2  h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

		        	<div class="col-lg-12 col-md-12 bg-color arrondie ">
					            <div class="mb-md-5 mt-md-4 pb-5">

					              <h2 class="fw-bold mb-2 text-uppercase">CREER UNE RECETTE</h2>
					              <p class="text-white-50 mb-5">Partager vos recettes préférées</p>

			        <div class="row">
			        	
			        	<div class="col-lg-12 col-md-12 bg-color arrondie py-5 ">
			        		<form>
			        			<input type="text" class="form-control my-3" name="recette" placeholder="Nom de la recette"><br>
			        			<div class="row">
			        				<div class="col-lg-6 col-md-6">
										<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
										  <option selected disabled>Catégorie</option>
										  <option value="1">One</option>
										  <option value="2">Two</option>
										  <option value="3">Three</option>
										</select>
									</div>
			        				<div class="col-lg-6 col-md-6 ">
										<input type="text" class="form-control" name="temps" placeholder="Temps de préparation ( h : mn )"><br>
									</div>
									
								</div>

								<div class="row">

						       		<h3 class="text-center py-3">Ajouter une image à ma recette </h3>
						       		<form method="POST" enctype="multipart/form-data">
							       		<div class="col-lg-6 col-md-6 text-center">
											<input type="file" name="fichier"> <br>
										</div>
										<div class="col-lg-6 col-md-6  ">
											<button class="btn btn-outline-light btn-lg px-2 " type="submit">Envoyer</button>
										</div>
									</form>
						       		
						       	</div>

						       	<div class="row">

						       		<div class="col-lg-12 col-md-12 col-sm-12 input-group  ">

						       			<textarea class="form-control" aria-label="With textarea" placeholder="Votre Recette" name="recette"></textarea>
						       			
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

<!-- Upload d'image -->

<?php
	if(!empty($_FILES)){
		$file_name = $_FILES['fichier']['name'];
		$extension = strrchr($file_name, ".");

		$file_path = $_FILES['fichier']['tmp_name'];
		$destination = 'C:\MAMP\htdocs\Projet\fichier/'.$file_name;
		$logo = imagecreatefrompng('images\bmw.png');
		
		
		

		$extension_authorised = array('.png', '.PNG', '.jpg', '.jpeg', '.JPG', '.JPEG');

		
		if(in_array($extension, $extension_authorised)){
			//récupération des dimensions de l'image
			$temp = getimagesize($file_name);

			//création d'une canvas de mêmes dimensions que l'image
			imagecreate($temp[0], $temp[1]);


			imagecopy($img, $file_path, 0, 0, 0, 0, $temp[0], $temp[1]);
			imagecopy($img, $logo, 20, 20, 0, 0, 250, 250);

			if(move_uploaded_file($file_path, $destination)){
				echo "Envoyé !";
			}

		}else{
			echo "Veuillez rentrer choisir une image au format PNG, JPG ou JPEG";
		}
	}



?>