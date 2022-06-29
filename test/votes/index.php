<?php
session_start();
require '../../functions.php';

echo '<p id="user_id" hidden="hidden">'.$_SESSION['id'].'</p>';
echo '<p id="user_token" hidden="hidden">'.$_SESSION['token'].'</p>';

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



<div class="container">
	<div class="btn-group-vertical" role="" aria-label="Groupe de boutons en colonne">
        <button type="button" id='upvote-1' class="btn btn-secondary">^</button>
        <div id='1' class='text-center'>test</div>
        <button type="button" id='downvote-1' class="btn btn-secondary">v</button>
	</div>

</div>




<script src="votee.js"></script>
<!--

<button id="upvote-1">Upvote</button>
<p id="1"></p>
<button id="downvote-1">Downvote</button><br>


<button id="upvote-2">Upvote</button>
<p id="2"></p>
<button id="downvote-2">Downvote</button><br>
<button id="upvote-3">Upvote</button>
<p id="3"></p>
<button id="downvote-3">Downvote</button><br>
-->