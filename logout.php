<?php
session_start();

include "functions.php";

updateLogs($_SESSION['id'], "déconnexion");

session_destroy();


header("Location: index.php");