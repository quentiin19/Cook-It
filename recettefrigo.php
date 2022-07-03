<?php
include 'template/header.php';


if(isConnected()){
    echo '<p hidden="hidden" id="id-user">'.$_GET['id'].'</p>';


?>
<input type="number" id="difficulty" placeholder="Nombre d'ingrédient non détenu autorisé" size="30">
<div id='recettes'></div>


<script src="ressources/js/fridgerecipe.js"></script>
<?php
}else{
    header('Location: login.php');
}