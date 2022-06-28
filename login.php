<?php 
	include "./template/header.php";
?>

<div class="row ">
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
	<div class="col-lg-12 col-md-12 col-sm-12h-auto arrondie ">
		<div class="container py-2 h-auto ">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5 ">
					<div class="card bg-color text-white" style="border-radius: 1rem;">
					    <div class="card-body p-5 text-center">
							<div class="mb-md-5 mt-md-4 pb-5">
					            <h2 class="fw-bold mb-2 text-uppercase">Se Connecter</h2>
					            <p class="text-white-50 mb-5">Veillez entrer votre identifiant et votre mot de passe </p>
					            
								<?php
									echo '<pre>';
									print_r($_POST);
									echo '</pre>';

									if(isset($_POST) && !empty($_POST['email']) && !empty($_POST['pwd']) && count($_POST)==2){
										$pdo = connectDB();
										$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE MAIL=:email");
										$queryPrepared->execute(["email"=>$_POST['email']]);
										$results = $queryPrepared->fetch();
										
										if (isset($results['role'])) {
											if($results['role'] >=1){
												if(!empty($results) && password_verify($_POST['pwd'], $results['HASHPWD'])){
													
										
													$token = createToken();
													updateToken($results["ID"], $token);
													//Insertion dans la session du token
													$_SESSION['email'] = $_POST['email'];
													$_SESSION['id'] = $results["ID"];
													$_SESSION['token'] = $token;
	
													//update des logs
													updateLogs($results["ID"], "connexion");
	
													//redirection
													header("location: index.php");
										
												}else{
													echo '<p class="bg-danger text-white">Identifiants incorrects</p>';
												}
											}else{
												echo '<p class="bg-danger text-white">Veuillez vérifier vos mails pour confirmer votre compte</p>';
											}
										}else{
											echo '<p class="bg-danger text-white">Ce compte n\'existe pas</p>';
										}
									}else{
										echo '<p class="bg-danger text-white">Veuillez remplir tous les champs</p>';
									}
								?>

								<form method="POST" action="">
									<input type="hidden" name="clicked" >
					              	<div class="form-outline form-white mb-4">
					                	<input  name="email" type="email" id="typeEmailX" placeholder="Email" class="form-control form-control-lg" />
					                	<label class="form-label" for="typeEmailX"></label>
					              	</div>

					              	<div class="form-outline form-white mb-4">
					                	<input type="password" name="pwd" id="typePasswordX"  placeholder="Mot de passe" class="form-control form-control-lg" />
					                	<label class="form-label" for="typePasswordX"></label>
					              	</div>

					              	<p class="small mb-5 pb-lg-2"><a class="text-white-50" href="mdp_oublie.php">Mot de passe oublié ?</a></p>
					              	<button class="btn btn-outline-light btn-lg px-2" type="submit">Se Connecter</button>
					            </form>

					          	<p class="mb-0">Vous n'avez pas de compte ? <a href="SignUp.php" class="text-white-50 fw-bold">S'inscrire</a></p>
								
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

