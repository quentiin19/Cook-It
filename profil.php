<?php include "template/header.php";?>

<div class="container">
	<h1>Salut !</h1>

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
							<td>'.$user["id"].'</td>
							<td>'.$user["lastname"].'</td>
							<td>'.$user["firstname"].'</td>
							<td>'.$user["pseudo"].'</td>
							<td>'.$user["email"].'</td>
							<td>
								<div class="btn-group">
									<a href="delUser.php?id='.$user["id"].'" class="btn btn-danger">Supprimer</a>
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