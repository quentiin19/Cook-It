<?php
session_start();

include "functions.php";

//update des logs
updateLogs($_SESSION['id'], "déconnexion");

//destruction de la session actuelle
session_destroy();



header("Location: index.php");
