<?php
session_start();
require "functions.php";
echo '<pre>';print_r($_POST);echo '</pre>';
echo '<pre>';print_r($_SESSION);echo '</pre>';
$id=$_SESSION['id'];
//Vérification si admin
if(isAdmin()){
	$pdo = connectDB();

	if(
		!isset($_POST["firstname"]) ||
		!isset($_POST["lastname"]) || 
		empty($_POST["pseudo"]) ||
		!isset($_POST["description"]) ||
		count($_POST)!=5
	){

		die("Tentative de Hack ...");

	}




//récupérer les données du formulaire
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$pseudo = $_POST["pseudo"];
$description = $_POST["description"];

//nettoyage des données
$firstname = ucwords(strtolower(trim($firstname)));
$lastname = strtoupper(trim($lastname));
$pseudo = ucwords(strtolower(trim($pseudo)));
$description = trim($description);

//Vérification des données

//prénom : Min 2, Max 45 ou empty
if( strlen($firstname)==1 || strlen($firstname)>45 ){
	$errors[] = "Votre prénom doit faire plus de 2 caractères";
}

//nom : Min 2, Max 100 ou empty
if( strlen($lastname)==1 || strlen($lastname)>100 ){
	$errors[] = "Votre nom doit faire plus de 2 caractères";
}

//pseudo : Min 4 Max 60
if( strlen($pseudo)<4 || strlen($pseudo)>60 ){
	$errors[] = "Votre pseudo doit faire entre 4 et 60 caractères";
}

//Modification des infos de l'utilisateur dans la BDD
$queryPrepared = $pdo->prepare("Update USER SET PSEUDO =:pseudo, FIRSTNAME =:firstname, LASTNAME =:lastname, DESCRIPTION_PROFIL=:desc WHERE ID =:id");
$queryPrepared->execute(["pseudo"=> $pseudo, "firstname"=>$firstname, "lastname"=>$lastname,"desc"=>$description, "id"=>$id ]);

//update des logs
updateLogs($id, "modification du profil par un administrateur (".$_SESSION['id'].")");

//redirection vers la page membre
header("Location: https://cookit.ovh/index.php");

}elseif(isConnected() == $id){

	$pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT HASHPWD FROM USER WHERE ID=:id");
    $queryPrepared->execute(["id"=>$id]);
    $results=$queryPrepared->fetch();

	print_r($_POST);
	print_r($_SESSION);
	if(
		!isset($_POST["firstname"]) ||
		!isset($_POST["lastname"]) || 
		empty($_POST["pseudo"]) ||
		empty($_POST["password"])||
		!isset($_POST["description"]) ||
		count($_POST)!=5
	){

		die("Tentative de Hack ...");

	}

	//récupérer les données du formulaire

	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$pseudo = $_POST["pseudo"];
	$pwd = $_POST["password"];
	$description = $_POST["description"];

	//vérifier les données
	$errors = [];

	//nettoyer les données
	$firstname = ucwords(strtolower(trim($firstname)));
	$lastname = strtoupper(trim($lastname));
	$pseudo = ucwords(strtolower(trim($pseudo)));
	$description = trim($description);

	// Verif champs

	//prénom : Min 2, Max 45 ou empty
	if( strlen($firstname)==1 || strlen($firstname)>45 ){
		$errors[] = "Votre prénom doit faire plus de 2 caractères";
	}

	//nom : Min 2, Max 100 ou empty
	if( strlen($lastname)==1 || strlen($lastname)>100 ){
		$errors[] = "Votre nom doit faire plus de 2 caractères";
	}

	//pseudo : Min 4 Max 60
	if( strlen($pseudo)<4 || strlen($pseudo)>60 ){
		$errors[] = "Votre pseudo doit faire entre 4 et 60 caractères";
	}

	//description >300
	if( strlen($description)>300){
		$errors[] = "Votre description est trop longue";
	}
	
	//Vérification des mots de passes
	$hashpwd= password_hash($pwd, PASSWORD_DEFAULT);

	if ($results[0] != $hashpwd){
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
	//Hashage du nouveau mdp
	$hashpwd= password_hash($pwd, PASSWORD_DEFAULT);

	//Modification des infos de l'utilisateur dans la BDD
	$queryPrepared = $pdo->prepare("Update USER SET PSEUDO =:pseudo, FIRSTNAME =:firstname, LASTNAME =:lastname, DESCRIPTION_PROFIL=:desc WHERE ID =:id");
	$queryPrepared->execute(["pseudo"=> $pseudo, "firstname"=>$firstname, "lastname"=>$lastname,"desc"=>$description, "id"=>$id ]);
	
	//update des logs
	updateLogs($id, "modification du profil");

	//Redirection
	header("Location: https://cookit.ovh/index.php");
	
	}else{
		die("Il faut se connecter !!!");
}

