<?php
session_start();
require '../../functions.php';
require '../../ressources/fpdf184/fpdf.php';

echo '<p id="user_id" hidden="hidden">'.$_SESSION['id'].'</p>';
echo '<p id="user_token" hidden="hidden">'.$_SESSION['token'].'</p>';

?>

<button id="upvote-1">Upvote</button>
<p id="1"></p>
<button id="downvote-1">Downvote</button><br>


<script src="vote.js"></script>
<!--
<button id="upvote-2">Upvote</button>
<p id="2"></p>
<button id="downvote-2">Downvote</button><br>
<button id="upvote-3">Upvote</button>
<p id="3"></p>
<button id="downvote-3">Downvote</button><br>
-->