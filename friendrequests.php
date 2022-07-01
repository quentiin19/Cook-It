<?php 
include "template/header.php";


if (isConnected() == $_SESSION['id']){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT *  FROM SUBSCRIPTION WHERE ID_SUBSCRIPTION = :idstion AND STATUS = 0;");
	$queryPrepared->execute(["idstion" => $_GET['id']]);
	$friends = $queryPrepared->fetchAll();

}
echo'<pre>';
print_r($friends);
echo'</pre>';

// echo'
// <div class="row">
//     <div class="col-lg-2"></div>
//     <div class="col-lg-8">';
// foreach ($friends as $friend){
//     echo '
//             <div class="col-lg-4 col-md-4 col-sm-1 py-3">
//                 <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
//                     <a href="https://cookit.ovh/profil.php?id='.$friend['ID_SUBSCRIBER'].'"></a>        
//                 </div>
//             </div>';
// }
// echo '
//     </div>
//     <div class="col-lg-2"></div>
// </div>';


?>