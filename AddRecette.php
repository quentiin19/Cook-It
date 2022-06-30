<?php   
		include "template/header.php";
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie  ">
        <div class="container py-2  h-auto  ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card bg-color text-white" style="border-radius: 1rem;">
                    <div class="card-body  text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">CREER UNE RECETTE</h2>
                            <p class="text-white-50 mb-5">Partager vos recettes préférées</p>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 bg-color arrondie py-5 ">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <h3 class="text-center">Titre </h3>
                                                <input type="text" class="form-control my-3" name="recette"
                                                    placeholder="Nom de la recette" required="required"><br>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <h3 class="text-center">Ajouter une image </h3>
                                                <input type="file" name="fichier" id="inpFile" required="required">
												<div class="image-preview" id="imagePreview">
													<img src="" alt="image Preview" class="image-preview__image">
													<span class="image-preview__default-text">Image Preview</span>
												</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 pl-2">
                                                <h3 class="text-center py-3">Votre Recette </h3>
                                                <textarea class="form-control my-3" id="textAreaExample1"
                                                    placeholder="Les étapes de votre recette" name="recette_description"
                                                    rows="20"></textarea>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <h3 class="text-center py-3">Ajouter les ingrédients </h3>

                                                <!--scroll-->
                                                <div>
                                                    <div class="overflow-auto " style="height : 300px">
                                                        <?php
											$pdo = connectDB();

												$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
												$queryPrepared->execute();
												$results = $queryPrepared->fetchAll();

												foreach ($results as $key => $ingredient) { 
													echo '<div class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
																<div class="row align-items-center">
																		<div class="col-lg-1 col-md-1 col-sm-6">
																			<input  type="checkbox" name="checkbox'.$ingredient['ID'].'">
																		</div>
																		<div class="col-lg-3 col-md-3 col-sm-6">
																			<img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
																		</div>
																		<div class="col-lg-3 col-md-3 col-sm-3">
																			<p>'.$ingredient['NAME'].'</p>
																		</div>
																		<div class="col-lg-3 col-md-2 col-sm-6 ">
																			<input class="input-width text-dark" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
																		</div>
																	<div class="col-lg-2 col-md-3 col-sm-3">
																			'.$ingredient['UNIT'].'
																		</div>		
																</div>
															</div>';
													
												}?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <input type="submit" value="Envoyer"></button>
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
</div>

<?php



if(!empty($_POST)){
		
	if(!empty($_FILES)){
		//enregistrement de l'image sur le serveur
		//nom du fichier
		$file_name = $_FILES['fichier']['name'];

		//emplacement du fichier
		$file_path = $_FILES['fichier']['tmp_name'];

		//destination que l'on souhaite pour fichier
		$destination = '/var/www/html/ProjAnn/ressources/images/images-recettes/';

		//extention du fichier
		$extension = strrchr($file_name, ".");
	
		//liste des extentions autorisées à être uploadées
		$extension_authorised = array('.png', '.PNG', '.jpg', '.jpeg', '.JPG', '.JPEG');

		//si le fichier est une image autorisé
		if(in_array($extension, $extension_authorised)){
			// sert à bouger le fichier qui vient d'être upload dans la destination que l'on veut
			if(move_uploaded_file($_FILES['fichier']['tmp_name'], $destination.$file_name)){
				echo "Envoyé !";

				//création du filigranne
				$logo = imagecreatefrompng('ressources/images/Utilitaires/logo.png');

				//création de l'image de base
				if ($extension == '.png' || $extension == '.PNG') {
					$img = imagecreatefrompng($destination.$file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".png";

				}elseif ($extension == '.jpeg' || $extension == '.JPEG') {
					$img = imagecreatefromjpeg($destination.$file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".jpeg";

				}elseif ($extension == '.jpg' || $extension == '.JPG') {
					$img = imagecreatefromjpeg($destination.$file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".jpg";

				}else {
					die("hack");
				}

				// Définit les marges pour le cachet et récupère la hauteur et la largeur de celui-ci
				$marge_right = 10;
				$marge_bottom = 10;
				$sx = imagesx($logo);
				$sy = imagesy($logo);
				//création d'une canvas de mêmes dimensions que l'image
				// $final_img = imagecreate(imagesx($img), imagesy($img));

				// Fonction pour copier une image sur une autre
				// imagecopy($final_img, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
				// imagecopy($final_img, $logo, 0, 0, 0, 0, 81, 75);

				// Copie le cachet sur la photo en utilisant les marges et la largeur de la
				// photo originale  afin de calculer la position du cachet 
				imagecopy($img, $logo, imagesx($img) - $sx - $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, imagesx($logo), imagesy($logo));
				
				//suppression de l'ancien fichier
				// unlink($destination.$file_name);

				//création de l'image
				if ($extension == '.png' || $extension == '.PNG') {
					imagepng($img, $destination.$final_file_name);
				}elseif($extension == '.jpeg' || $extension == '.JPEG' || $extension == '.jpg' || $extension == '.JPG'){
					imagejpeg($img, $destination.$final_file_name);
				}
				

				//libération de la mémoire
				imagedestroy($img);
				imagedestroy($logo);

			}
			else{
				echo "Veuillez rentrer choisir une image au format PNG, JPG ou JPEG";
			}
				
		}
	
	}

	//insertion recette dans tables recipes
	$recette = $_POST["recette"];
	$recette_description = $_POST["recette_description"];

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("INSERT INTO RECIPES (ID_CREATOR, TITLE, DESCRIPTION, PICTURE_PATH) VALUES (:idcreator, :title, :recettedesc, :path);");
	$queryPrepared->execute([
							"idcreator"=>$_SESSION['id'],
							"title"=>$recette,
							"recettedesc"=>$recette_description,
							"path"=>"https://cookit.ovh/ressources/images/images-recettes/".$final_file_name
	]);


	//update des logs
	updateLogs($_SESSION['id'], "création de la recette : ".$recette);



	//récupération de l'id de la recette pour créer les insertions dans la table NEED
	$queryPrepared = $pdo->prepare("SELECT ID_RECIPE FROM RECIPES WHERE ID_CREATOR=:id AND TITLE=:title");
	$queryPrepared->execute(["id"=>$_SESSION['id'], "title"=>$recette]);
	$result = $queryPrepared->fetch();

	//insertion ingrédient dans la table NEED
	for ($i = 1; $i<6; $i++){
		if(isset($_POST['checkbox'.$i])){
			$quantity = $_POST["quantity".$i];
			$queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
			$queryPrepared->execute(["quantity"=>$quantity, "id_ingr"=>$i ,"id_recipe"=>$result['ID_RECIPE']]);
		}
	}
	


	header("Location: recette.php?id=".$result['ID_RECIPE']);
}

?>

<script src='preview-image.js'></script>
<?php include "template/footer.php";?>