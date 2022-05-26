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