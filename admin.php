<?php 
include "template/header.php";
if (isAdmin()){
?>

<div class="container">
	<h1>Gestion des utilisateurs</h1>

	<?php 
	if (isConnected()) {
		$pdo = connectDB();

		$queryPrepared = $pdo->prepare("SELECT * FROM USER");
		$queryPrepared->execute();
		$results = $queryPrepared->fetchAll();
		?>


		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Pseudo</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				foreach ($results as $user) {
					echo '<tr>
							<td>'.$user["ID"].'</td>
							<td>'.$user["LASTNAME"].'</td>
							<td>'.$user["FIRSTNAME"].'</td>
							<td>'.$user["PSEUDO"].'</td>
							<td>'.$user["MAIL"].'</td>
							<td>
								<div class="btn-group">
									<a href="delUser.php?id='.$user["ID"].'" class="btn btn-danger">Supprimer</a>
									<a href="#" class="btn btn-warning" >Modifier</a>
								</div>
							</td>
						</tr>';
				}
				?>

									

			</tbody>
		</table>

		<?php
	}
	?>

</div>
<?php

include "template/footer.php";

}else{
    header("Location: index.php");
}

?>

<?php
session_start();
require "functions.php";

//Vérification de l'utilisateur
$id = $_GET["id"];
if(!isConnected()){
	die("Il faut se connecter !!!");
}


//Suppression du user en bdd
$pdo = connectDB();
$queryPrepared = $pdo->prepare("DELETE FROM USER WHERE id=:id");
$queryPrepared->execute(["id"=>$id]);

//Si c'est le user actuellement connecté je le deco
if ($_SESSION['id'] == $id){
	header("Location: logout.php");
}


//redirection sur la home
header("Location: index.php");