<?php
include 'template/header.php';


if(isConnected() == $_GET['id']){
    echo '<p hidden="hidden" id="id-user">'.$_GET['id'].'</p>';


?>

<div id='recettes'></div>


<script src="ressources/js/fridgerecipe.js"></script>
<?php
}else{
    header('Location: login.php');
}