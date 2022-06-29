<?php
session_start();
include '../../functions.php';


if(isConnected()){
    echo '<p id="id-sender" hidden="hidden">'.$_SESSION['id'].'</p>';
    echo '<p id="id-receveur" hidden="hidden">'.$_GET['id'].'</p>';
    echo '<p id="token" hidden="hidden">'.$_SESSION['token'].'</p>';
}

?>

<div id="message-canva"></div>
<input type="text" id="message-input">
<button id="send-message">envoyer</button>

<script src="script.js"></script>