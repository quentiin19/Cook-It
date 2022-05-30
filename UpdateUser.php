<?php
session_start();
require "functions.php";



//Vérification de l'utilisateur
$id = $_SESSION["id"];
if(!isConnected()){
	die("Il faut se connecter !!!");
}else{
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE id=:id");
    $queryPrepared->execute(["id"=>$id]);
    $results=$queryPrepared->fetch();
}

if(
	!isset($_POST["firstname"]) ||
	!isset($_POST["lastname"]) || 
	empty($_POST["pseudo"]) ||
    empty($_POST["oldpassword"])||
	empty($_POST["password"]) ||
	empty($_POST["passwordConfirm"]) ||
	count($_POST)!=6
){

	die("Tentative de Hack ...");

}

//récupérer les données du formulaire

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$pseudo = $_POST["pseudo"];
$oldpwd = $_POST["oldpassword"];
$pwd = $_POST["password"];
$pwdConfirm = $_POST["passwordConfirm"];

//vérifier les données
$errors = [];

//Vérification des mots de passes
$hasholdpwd= password_hash($oldpwd, PASSWORD_DEFAULT);

if ($results["HASHPWD"] != $hasholdpwd){
    $errors[] = "Votre ancien mot de passe n'est pas bon";
}


//Mot de passe : Min 8, Maj, Min et chiffre
if(strlen($pwd) < 8 ||
preg_match("#\d#", $pwd)==0 ||
preg_match("#[a-z]#", $pwd)==0 ||
preg_match("#[A-Z]#", $pwd)==0 
) {
	$errors[] = "Votre mot de passe doit faire plus de 8 caractères avec une minuscule, une majuscule et un chiffre";
}
//Confirmation : égalité
if( $pwd != $pwdConfirm){
	$errors[] = "Votre mot de passe de confirmation ne correspond pas";
}

//Hashage du nouveau mdp
$hashpwd= password_hash($pwd, PASSWORD_DEFAULT);

//Modification des infos de l'utilisateur dans la BDD
$queryPrepared = $pdo->prepare("Update USER SET PSEUDO =:pseudo, HASHPWD =:hashpwd, FIRSTNAME =:firstname, LASTNAME =:lastname WHERE ID =:id");
$queryPrepared->execute(["pseudo"=> $pseudo, "hashpwd"=> $hashpwd, "fistname"=>$firstname, "lastname"=>$lastname, "id"=>$id ]);


//update des logs
updateLogs($results["ID"], "modification du profil");