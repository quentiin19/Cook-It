<?php include "template/header.php";?>


<div class="row">

			<div class="col-lg-2 col-md-1 col-sm-0"></div>

			<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
					  <div class="container py-2  h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

					            <div class="mb-md-5 mt-md-4 pb-5">
								<div class="row">
									<div class="col-lg-12">
										<?php include "avatar/avatar.php";?>
									</div>
									<?php 
										if (isConnected()) {
											$pdo = connectDB();

											$queryPrepared = $pdo->prepare("SELECT ID, LASTNAME, FIRSTNAME, PSEUDO, MAIL FROM USER where ID=:id");
											$queryPrepared->execute();
											$results = $queryPrepared->fetch();
												
														echo '<tr>
																<td>'.$results["ID"].'</td>
																<td>'.$results["LASTNAME"].'</td>
																<td>'.$results["FIRSTNAME"].'</td>
																<td>'.$results["PSEUDO"].'</td>
																<td>'.$results["MAIL"].'</td>'

										}
										?>

					            </div>
					           </div>
					        </div>
					    </div>
					  </div>
			</div>
			<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>


<?php include "template/footer.php";?>