<?php
include 'template/header.php';


if (isConnected()) {
    //récupération de l'id de l'utilisateur pour l'utiliser dans le script js
    echo '<p hidden="hidden" id="id-user">' . $_GET['id'] . '</p>';


?>

    <p>Nombre d'ingrédient non détenu autorisé : </p>
    <input type="number" id="difficulty" value='0'>
    <div id='recettes'></div>


    <script src="ressources/js/fridgerecipe.js"></script>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
} else {
    header('Location: login.php');
}
include "template/footer.php"; ?>