<?php include "template/header.php";?>

<?php 
	if (isConnected()) {
		$pdo = connectDB();

		$queryPrepared = $pdo->prepare("SELECT * FROM iw_user");
		$queryPrepared->execute();
		$results = $queryPrepared->fetchAll();
?>

<div class="row">

			<div class="col-lg-2 col-md-1 col-sm-0"></div>

			<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
					  <div class="container py-2  h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

					            <div class="mb-md-5 mt-md-4 pb-5">
					            	<div class="row">
					            		<table class="table table-hover my-5 p-4 table-dark">
								            <thead>
								                <th scope="col">ID</th>
								                <th scope="col">EMAIL</th>
								                <th scope="col">USERNAME</th>
								            </thead>
								            <tbody>
								                <?php
								                for ($i = 0; $i < count($result); $i++) {
								                    $user = $result[$i];
								                    echo '<tr><th scope="row">' . $user["id"] . '</th>';
								                    echo '<td>' . $user["email"] . '</td>';
								                    echo '<td>' . $user["username"] . '</td>';
								                }
								                ?>
								            </tbody>
								        </table>
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