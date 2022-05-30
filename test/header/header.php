<?php 
		session_start();
		require "functions.php";
	?>
	<!DOCTYPE html>
	<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@200&display=swap" rel="stylesheet"> -->
		<link rel="stylesheet"  href="./ressources/css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<link rel="icon" href="../ressources/images/Utilitaires/logo.ico">
		<title>Cook'It</title>
	</head>
	<body class="h-auto bg-couleur">
		<header>

			<!-- Section menu haut -->

			 <div class=" bg-color  p-2 row align-self-center" >
				<div class="col-lg-3 col-md-3">
					<a href="index.php"><button type="button" class="btn text-white btn-lg"><img src="../ressources/images/Utilitaires/logo.png" height ="80vh" width="100vw" />Cook'IT</button></a>
				</div>
				<div class="col-lg-6 col-md-4 text-center align-self-center">
					<h1>Cook'It</h1>
				</div>

				<!-- <?php
					$_SESSION['pseudo'] = $pseudo;
				?> -->
				<?php 
				if (isConnected()){
				echo'<div class="col-lg-1 col-md-2 position-absolute align-self-center end-0 ">
								<a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">Mon profil</a>
								<ul class="dropdown-menu">
									<li><a href="#" class="dropdown-item">Mes abonnements</a></li>
									<li><a href="#" class="dropdown-item">Mes recettes</a></li>
									<li><a href="#" class="dropdown-item">Modifier mon profil</a></li>
									<li><a href="./profil.php" class="dropdown-item">Consulter mon profil</a></li>
									<li><a href="logout.php" class="dropdown-item">Se déconnecter</a></li>';
									
									if (isAdmin()) {
										echo'<li><a href="./admin.php" class="dropdown-item">Gérer les utilisateurs</a></li>
										</ul>';
									}
									else {
									echo "c pas bon chef";
									}
								echo'</ul>
						
				    </div>';
                }else{
                    echo'<div class="col-lg-2 col-md-2  align-self-center text-right ">
                                <a href="./login.php" class=" text-white">Se Connecter</a>
                        </div>
                        
                        <div class="col-lg-1 col-md-2  align-self-center ">
                                <a href="./SignUp.php" class="text-white">S\'inscrire</a>	
                        </div>';
                }
                ?>

                <div class="container-fluid ">
                    <nav class="navbar navbar-expand-md  ">
                        <div class="container-fluid">
                            <ul class="navbar-nav">

                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">Recettes</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item">Viandes</a></li>
                                        <li><a href="#" class="dropdown-item">Légumes</a></li>
                                        
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">Vos Abonnements</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item">Test</a></li>
                                        
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">Vos Favoris</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item">Viandes</a></li>
                                        <li><a href="#" class="dropdown-item">Légumes</a></li>
                                        
                                    </ul>
                                </li>

                                <li class="nav-item ">
                                    <a href="AddRecette.php" class="nav-link  text-white" >Vos Recettes</a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>


			
		</header>
