<?php
include '../../template/header.php';

echo '<p id="user_id" hidden="hidden">'.$_SESSION['id'].'</p>';
echo '<p id="user_token" hidden="hidden">'.$_SESSION['token'].'</p>';

?>



<div class="container">
	<h1>Boutons</h1>
	<div class="btn-group-vertical" role="group" aria-label="Groupe de boutons en colonne">
	<button type="button" id='upvote-1' class="btn btn-secondary">Haut</button>
	<button type="button" id='downvote-1' class="btn btn-secondary">Bas</button>
	</div>

	<p id='1'>test</p>
</div>




<script src="vote.js"></script>
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