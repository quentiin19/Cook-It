<?php
session_start();
require "functions.php";
echo '<pre>';
print_r($_POST);
echo '</pre>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
$id = $_SESSION['id'];
//Vérification si admin
if (isAdmin()) {
	$pdo = connectDB();

	if (
		empty($_POST["oldpassword"]) ||
		empty($_POST["password"]) ||
		empty($_POST["passwordConfirm"]) ||
		count($_POST) != 4
	) {

		die("Tentative de Hack ...");
	}


	//update des logs
	updateLogs($id, "modification du profil par un administrateur (" . $_SESSION['id'] . ")");

	//redirection vers la page membre
	header("Location: admin.php?id=" . $id);
} elseif (isConnected() == $id) {

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT HASHPWD FROM USER WHERE ID=:id");
	$queryPrepared->execute(["id" => $id]);
	$results = $queryPrepared->fetch();

	print_r($_POST);
	print_r($_SESSION);
	if (
		empty($_POST["oldpassword"]) ||
		empty($_POST["password"]) ||
		empty($_POST["passwordConfirm"]) ||
		count($_POST) != 3
	) {

		die("Tentative de Hack ...");
	}

	//récupérer les données du formulaire
	$oldpwd = $_POST["oldpassword"];
	$pwd = $_POST["password"];
	$pwdConfirm = $_POST["passwordConfirm"];

	//vérifier les données
	$errors = [];

	//Vérification des mots de passes
	$hasholdpwd = password_hash($oldpwd, PASSWORD_DEFAULT);

	if ($results[0] != $hasholdpwd) {
		$errors[] = "Votre ancien mot de passe n'est pas bon";
	}


	//Mot de passe : Min 8, Maj, Min et chiffre
	if (
		strlen($pwd) < 8 ||
		preg_match("#\d#", $pwd) == 0 ||
		preg_match("#[a-z]#", $pwd) == 0 ||
		preg_match("#[A-Z]#", $pwd) == 0
	) {
		$errors[] = "Votre mot de passe doit faire plus de 8 caractères avec une minuscule, une majuscule et un chiffre";
	}
	//Confirmation : égalité
	if ($pwd != $pwdConfirm) {
		$errors[] = "Votre mot de passe de confirmation ne correspond pas";
	}


	//Hashage du nouveau mdp
	$hashpwd = password_hash($pwd, PASSWORD_DEFAULT);

	//Modification des infos de l'utilisateur dans la BDD
	$queryPrepared = $pdo->prepare("update USER SET HASHPWD =:hashpwd WHERE ID =:id;");
	$queryPrepared->execute(["hashpwd" => $hashpwd, "id" => $id]);

	//update des logs
	updateLogs($id, "modification du profil");

	//Redirection
	header("Location: profil.php?id=" . $id);
} else {
	die("Il faut se connecter !!!");
}
