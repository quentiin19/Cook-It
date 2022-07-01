<?php
session_start();
require "functions.php";
echo '<pre>';print_r($_POST);echo '</pre>';
echo '<pre>';print_r($_SESSION);echo '</pre>';
//Vérification si admin
if(isAdmin()){
	$pdo = connectDB();

	if(
		!isset($_POST["firstname"]) ||
		!isset($_POST["lastname"]) || 
		empty($_POST["pseudo"]) ||
		count($_POST)!=4
	){

		die("Tentative de Hack ...");

	}

$id=$_SESSION['id'];


//récupérer les données du formulaire
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$pseudo = $_POST["pseudo"];

//nettoyage des données
$firstname = ucwords(strtolower(trim($firstname)));
$lastname = strtoupper(trim($lastname));
$pseudo = ucwords(strtolower(trim($pseudo)));

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
$queryPrepared = $pdo->prepare("Update USER SET PSEUDO =:pseudo, FIRSTNAME =:firstname, LASTNAME =:lastname WHERE ID =:id");
$queryPrepared->execute(["pseudo"=> $pseudo, "firstname"=>$firstname, "lastname"=>$lastname, "id"=>$id ]);

//update des logs
updateLogs($id, "modification du profil par un administrateur (".$_SESSION['id'].")");

//redirection vers la page membre
header("Location: admin.php");

echo $id;
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
		empty($_POST["oldpassword"])||
		empty($_POST["password"]) ||
		empty($_POST["passwordConfirm"]) ||
		count($_POST)!=6
	){

		die("Tentative de Hack ...");
		print_r($_POST);

	}

	//récupérer les données du formulaire

	$email = $_POST["email"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$pseudo = $_POST["pseudo"];
	$oldpwd = $_POST["oldpassword"];
	$pwd = $_POST["password"];
	$pwdConfirm = $_POST["passwordConfirm"];

	//vérifier les données
	$errors = [];

	//nettoyer les données

	$email = strtolower(trim($email));
	$firstname = ucwords(strtolower(trim($firstname)));
	$lastname = strtoupper(trim($lastname));
	$pseudo = ucwords(strtolower(trim($pseudo)));

	// Verif champs

	//Email OK
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors[] = "Email incorrect";
	}else{

		//Vérification l'unicité de l'email
		$pdo = connectDB();
		$queryPrepared = $pdo->prepare("SELECT ID from USER WHERE EMAIL=:email");

		$queryPrepared->execute(["email"=>$email]);
		
		if(!empty($queryPrepared->fetch())){
			$errors[] = "L'email existe déjà en bdd";
		}


	}

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

	//Vérification des mots de passes
	$hasholdpwd= password_hash($oldpwd, PASSWORD_DEFAULT);

	if ($results[0] != $hasholdpwd){
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
	$queryPrepared = $pdo->prepare("update USER SET PSEUDO =:pseudo, HASHPWD =:hashpwd, FIRSTNAME =:firstname, LASTNAME =:lastname WHERE ID =:id");
	$queryPrepared->execute(["pseudo"=> $pseudo, "hashpwd"=> $hashpwd, "fistname"=> $firstname, "lastname"=> $lastname, "id"=> $id ]);
	
	//update des logs
	updateLogs($id, "modification du profil");

	//Redirection
	header("Location: profil.php");
	
}else{
	die("Il faut se connecter !!!");
}

