<?php
session_start();

include "functions.php";

// updateLogs($_SESSION['id'], "déconnexion");
unset($_SESSION['email']);
unset($_SESSION['token']);

header("Location: index.php");