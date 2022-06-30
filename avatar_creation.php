<?php
session_start();

include "functions.php";

//création des images dans la page php
$avatar = imagecreatefrompng("ressources/images/avatar-parts/skin".$_GET['skin'].".png");
$eye = imagecreatefrompng("ressources/images/avatar-parts/eye".$_GET['eye'].".png");
$mouth = imagecreatefrompng("ressources/images/avatar-parts/mouth".$_GET['mouth'].".png");


//recopie des images sur l'image de fond ($avatar)
imagecopy($avatar, $eye, 0, 0, 0, 0, 300, 300);
imagecopy($avatar, $mouth, 0, 0, 0, 0, 300, 300);

//création du fichier image qui portera comme nom l'id du user
imagepng($avatar, "ressources/images/avatars/".$_SESSION['id'].".png");

//libération de la mémoire
imagedestroy($avatar);
imagedestroy($eye);
imagedestroy($mouth);


//nom du fichier
$final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".png";

//changement de base de données du chemin de l'avatar
$path = "https://cookit.ovh/ressources/images/avatars/".$final_file_name.".png";

$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID = :id;");
$result = $queryPrepared->execute(["id"=>$_SESSION['id']]);

//mise en bdd du chemin pour l'image de l'avatar
$queryPrepared = $pdo->prepare("UPDATE USER SET PATH_AVATAR=:path WHERE ID = :id;");
$queryPrepared->execute(["path"=>$path, "id"=>$_SESSION['id']]);





header("Location: index.php");



