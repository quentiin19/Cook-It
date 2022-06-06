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

//changement de base de données du chemin de l'avatar
$path = "/var/www/html/ProjAnn/ressources/images/avatars/".$_SESSION['id'].".png";

$pdo = connectDB();

$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE ID = :id;");
$result = $queryPrepared->execute(["id"=>$_SESSION['id']]);

//si un avatar n'est pas encore définit
if (empty($result['PATH_AVATAR'])) {
    $queryPrepared = $pdo->prepare("UPDATE USER SET PATH_AVATAR=:path WHERE ID = :id;");
    $queryPrepared->execute(["path"=>$path, "id"=>$_SESSION['id']]);

//sinon, nous modifions l'avatar
}else{
    $queryPrepared = $pdo->prepare("UPDATE USER SET PATH_AVATAR=:path WHERE ID = :id;");
    $queryPrepared->execute(["path"=>$path, "id"=>$_SESSION['id']]);
}


//------------------------
//rajouter la possiblité de changer d'avatar en faisant une requetes en bdd pour voir s'il existe déjà un avatar ou non (si oui ne pas faire un insert, faire un modify)
//------------------------


header("Location: index.php");



