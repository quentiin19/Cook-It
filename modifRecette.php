<?php 
session_start();
include "./functions.php";?>
<?php

echo '<pre>';
print_r($_SESSION);
echo'</pre>';
echo '<pre>';
print_r($_POST);
echo'</pre>';

if (isConnected() == $_SESSION['id'] || isAdmin()) {
		$pdo = connectDB();
		
		
		$queryPrepared = $pdo->prepare("SELECT *  FROM RECIPES WHERE ID_CREATOR = :id  AND ID_RECIPE = :idr");
		$queryPrepared ->execute(["id" => $_SESSION["id"], "idr" => $_POST["idrecipe"]]);
		$resultR = $queryPrepared->fetch();
		
		$queryPrepared = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
		$queryPrepared ->execute(["id" => $_POST["idrecipe"]]);
		$resultN = $queryPrepared->fetchAll();
		
		$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
		$queryPrepared->execute(["id"=>$_POST["idrecipe"]]);
		$ingredients = $queryPrepared->fetchAll();
		
		echo '<pre>';
		print_r($resultN);
		echo'</pre>';
		echo '<pre>';
		print_r($ingredients);
		echo'</pre>';
		
		//on supprime tout les inredients pour pouvoir le mettre a jour après
		$queryPrepared = $pdo->prepare("DELETE FROM NEED WHERE ID_RECIPE = :id");
		$queryPrepared->execute(["id"=>$_POST["idrecipe"]]);
		
		
		
		//on rentre la nouvelle photo du
		if (!empty($_POST['fichier'])){
			print "<pre>";
			print_r($_FILES);
			print "</pre>";
			
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
		
				echo "test";
		
				//si le fichier est une image autorisé
				if(in_array($extension, $extension_authorised)){
					echo "test";
					// sert à bouger le fichier qui vient d'être upload dans la destination que l'on veut
					if(move_uploaded_file($_FILES['fichier']['tmp_name'], $destination.$file_name)){
						echo "Envoyé !";

						//création du nom de l'image
						$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".png";

		
						//création du filigranne
						$logo = imagecreatefrompng('ressource/images/Utilitaires/logo.png');
		
						//création de l'image de base
						$img = imagecreatefrompng($destination.$file_name);
		
						//création d'une canvas de mêmes dimensions que l'image
						$final_img = imagecreate(imagesx($img), imagesy($img));
		
		
						imagecopy($final_img, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
						imagecopy($final_img, $logo, 0, 0, 0, 0, 50, 50);
		
						//nom final du fichier (id de la recette et index de l'image) - A CHANGER
						$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".png";
		
						//suppression de l'ancien fichier
						unlink($destination.$file_name);
		
						//création de l'image
						imagepng($final_img, $destination.$final_file_name);
		
						//libération de la mémoire
						imagedestroy($logo);
						imagedestroy($img);
						imagedestroy($final_img);
					}
					else{
						echo "Veuillez rentrer choisir une image au format PNG, JPG ou JPEG";
					}
						
				}
			
			}
		
		}
		
		//on inscrit le chemin de la nouvelle image dans la recette
		$queryPrepared = $pdo->prepare("UPDATE RECIPES set PICTURE_PATH = :imgp where ID_RECIPE= :id;");
		$queryPrepared->execute(["imgp"=> $final_file_name, "id" => $_POST["idrecipe"]]);
		
		//on rentre le titre
		$queryPrepared = $pdo->prepare("UPDATE RECIPES set TITLE = :title WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["title"=>$_POST["title"],"id" => $_POST["idrecipe"]]);
		
		//on rentre la description
		$queryPrepared = $pdo->prepare("UPDATE RECIPES set DESCRIPTION = :desc WHERE ID_RECIPE = :id");
		$queryPrepared ->execute(["desc"=>$_POST["recette_description"],"id" => $_POST["idrecipe"]]);
		
		//on inscrit les nouvelles valeurs des ingredients 1 à 1
		for ($i = 1; $i<6; $i++){
			if(isset($_POST['checkbox'.$i])){
				$quantity = $_POST["quantity".$i];
				$queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
				$queryPrepared->execute(["quantity"=>$quantity, "id_ingr"=>$i ,"id_recipe"=>$_POST["idrecipe"]]);
			}
		}
		
		// header("Location: https://cookit.ovh/recette.php?id=".$_POST["idrecipe"]);
		
			
			
}		
?>