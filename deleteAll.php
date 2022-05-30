<?php
session_start();
require "functions.php";


//Suppression des recettes du user en bdd
$pdo = connectDB();
$queryPrepared = $pdo->prepare("DELETE FROM USER WHERE id=:id");
$queryPrepared->execute(["id"=>$id]);