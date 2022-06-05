<?php 
		session_start();
		require "../../functions.php";
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet"  href="../../ressources/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<link rel="icon" href="../../ressources/images/Utilitaires/logo.ico">
	<title>Cook'It</title>
</head>

<body class="h-auto bg-couleur">
	<header>

		<!-- Section menu haut -->

		<div class=" bg-color  p-2 row align-self-center" >
			<div class="col-lg-2 col-md-2 col-sm-6 align-self-center end-0 ">
				<img id="burger-menu-button" src="../../ressources/images/avatars/<?=$_SESSION['id']?>.png" height="100vh" width="100vw">
			</div>
			
			<div class="col-lg-8 col-md-8 col-sm-0 text-center align-self-center">
				<h1>Cook'It</h1>
			</div>

			<div class="col-lg-2 col-md-2 col-sm-5">
				<a href="index.php"><button type="button" class="btn text-white btn-lg"><img src="../ressources/images/Utilitaires/logo.png" height ="80vh" width="100vw" />Cook'IT</button></a>
			</div>

			
			
			
			<?php include "./ressources/menu.php"; ?>
			
			
			<script src="./script.js"></script>
		</div>
		<img src="../../ressources/images/Desserts/dessert1.jpeg" height="500px" width="500px">

			


		
	</header>
