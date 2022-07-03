<?php
session_start();

include "functions.php";

updateLogs($_SESSION['id'], "déconnexion");

session_destroy();

foreach ($_SESSION as $key => $value) {
    unset($_SESSION);
}


header("Location: index.php");