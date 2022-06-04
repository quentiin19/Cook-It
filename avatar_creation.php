<?php

include "functions.php";

//création des images dans la page php
$avatar = imagecreatefrompng("ressources/images/avatar-parts/skin".$_GET['skin'].".png");
$eye = imagecreatefrompng("ressources/images/avatar-parts/eye".$_GET['eye'].".png");
$mouth = imagecreatefrompng("ressources/images/avatar-parts/mouth".$_GET['mouth'].".png");


//recopie des images sur l'image de fond ($avatar)
imagecopy($avatar, $eye, 0, 0, 0, 0, 300, 300);
imagecopy($avatar, $mouth, 0, 0, 0, 0, 300, 300);

//création du fichier image qui portera comme nom l'id du user
imagepng($avatar, "/var/www/html/ProjAnn/ressources/images/avatars/".$_SESSION['id'].".png");

//libération de la mémoire
imagedestroy($avatar);
imagedestroy($eye);
imagedestroy($mouth);

//changement de base de données du chemin de l'avatar
$path = "/var/www/html/ProjAnn/ressources/images/avatars/".$_SESSION['id'].".png";

$pdo = connectDB();
$queryPrepared = $pdo->prepare("INSERT INTO USER (PATH_AVATAR) VALUES (:path);");
$queryPrepared->execute(["path"=>$path]);


header("Location: index.php");

