<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "functions.php";
require "./test/TestConfirmMail/inscription.php";



//Est-ce que je recois ce que j'ai demandé

if(
	empty($_POST["email"]) ||
	!isset($_POST["firstname"]) ||
	!isset($_POST["lastname"]) || 
	empty($_POST["pseudo"]) ||
	empty($_POST["password"]) ||
	empty($_POST["passwordConfirm"]) ||
	empty($_POST["cgu"]) ||
	!isset($_POST["birthday"])||
	count($_POST)!=8
){

	die("Tentative de Hack ...");

}




//récupérer les données du formulaire
$email = $_POST["email"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$pseudo = $_POST["pseudo"];
$pwd = $_POST["password"];
$pwdConfirm = $_POST["passwordConfirm"];
$birthday = $_POST["birthday"];
$cgu = $_POST["cgu"];



//nettoyer les données

$email = strtolower(trim($email));
$firstname = ucwords(strtolower(trim($firstname)));
$lastname = trim($lastname);
$pseudo = ucwords(strtolower(trim($pseudo)));


//vérifier les données
$errors = [];

//Email OK
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$errors[] = "Email incorrect";
}else{

	//Vérification l'unicité de l'email
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT ID from USER WHERE MAIL=:email");

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

//Date anniversaire : YYYY-mm-dd
//entre 16 et 100 ans
$birthdayExploded = explode("-", $birthday);

if( count($birthdayExploded)!=3 || !checkdate($birthdayExploded[1], $birthdayExploded[2], $birthdayExploded[0])){
	$errors[] = "date incorrecte";
}else{
	$age = (time() - strtotime($birthday))/60/60/24/365.2425;
	if($age < 16 || $age > 100){
		$errors[] = "Vous êtes trop jeune ou trop vieux";
	}
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


if(count($errors) == 0){



	$queryPrepared = $pdo->prepare("INSERT INTO USER (MAIL, FIRSTNAME, LASTNAME, PSEUDO, HASHPWD, role) 
		VALUES ( :email , :firstname, :lastname, :pseudo, :pwd , :role);");


	$pwd = password_hash($pwd, PASSWORD_DEFAULT);
	
	$queryPrepared->execute([
								"email"=>$email,
								"firstname"=>$firstname,
								"lastname"=>$lastname,
								"pseudo"=>$pseudo,
								"pwd"=>$pwd,
								"role"=>0
	]);
	
	$queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE MAIL = :email;");
	$queryPrepared->execute(["email"=>$email]);
	$result = $queryPrepared->fetch();
	
	$cle = rand(1000000,9000000);
	
	$_SESSION['id']= $result['ID'];
	$_SESSION['cle']= $cle;
	
	$from = 'support-cookit@cookit.com';
	$name = "Cookit-supportTeam";
	$subj = 'Mail de confirmation';
    $msg = '<a href=http://51.255.172.36/test/TestConfirmMail/verif.php?id='.$_SESSION['id'].'&cle='.$cle.'>Confirmer</a><h1>je suis ton père</h1>';
	smtpmailer($email,$from, $name ,$subj, $msg);

	echo "test2";
	header("Location: login.php");	


}else{
	
	$_SESSION['errors'] = $errors;
	echo'-------------------errors------------';
	print '<pre>';
	print_r($errors);
	print '</pre>';
	// header("Location: SignUp.php");
}


//Si aucune erreur insérer l'utilisateur en base de données puis rediriger sur la page de connexion


//Si il y a des erreurs rediriger sur la page d'inscription et afficher les erreurs

