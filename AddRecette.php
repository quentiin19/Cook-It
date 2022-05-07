<?php include "template/header.php";?>
	<div class="row">

			<div class="col-lg-2"></div>
			<div class="col-lg-8 background-body py-5 h-middle ">
				<div class="container py-5 ">


		        <div class="row">
		        	
		        	<div class="col-lg-12 col-md-12 bg-color arrondie ">
		        		<form>
		        			<input type="text" class="form-control my-3" name="recette" placeholder="Nom de la recette"><br>
		        			<div class="row">
		        				<div class="col-lg-6 col-md-6">
									<input type="text" class="form-control" name="Ingredients" placeholder="Vos ingrédients"><br>
								</div>
								<div class="col-lg-6 col-md-6">
									<select name="categorie" >
										<option value="" disabled selected hidden> Catégorie</option>
										<option>Entrées</option>
										<option>Plats</option>
										<option>Desserts</option>
									</select>
								</div>
							</div>
		        		</form>
		        	</div>
		        </div>
		    	</div>
			</div>
		    <div class="col-lg-2"></div>
<?php include "template/footer.php";?>