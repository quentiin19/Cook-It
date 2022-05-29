<?php
	if(!empty($_FILES)){
		$file_name = $_FILES['fichier']['name'];
		$extension = strrchr($file_name, ".");

		$file_path = $_FILES['fichier']['tmp_name'];
		$destination = '/var/www/html/ProjAnn/test/upload-image/files/'.$file_name;
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
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>upload fichier</title>
	</head>
	<body>
		<h1>Uploader une image jpg</h1>

		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="fichier"> <br>
			<input type="submit" value="Envoyer le fichier">
		</form>
	
	</body>
</html>