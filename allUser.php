<?php
include 'template/header.php';

//nous affichons cette page seulement si le user est déjà connecté
if (isConnected() == $_SESSION['id']) {
    ?>
    <input type="text" placeholder="rechercher" id="search-bar-user">
    <div id="users"></div>
    <div id="users-php">
    <?php

        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT ID, PSEUDO, PATH_AVATAR, DESCRIPTION_PROFIL FROM USER;");
        $queryPrepared->execute();
        $users = $queryPrepared->fetchAll();

        foreach ($users as $key => $user) {
            echo '<div class="col-lg-3 col-md-4 col-sm-6"> 
                    <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                        <div>
                            <img src="'.$user['PATH_AVATAR'].'" class="card-img-top cardh my-3"></img>
                        </div>
                        <div>
                            '.$user['PSEUDO'].' 
                        </div>
                        <a href="https://cookit.ovh/profil_membres.php?id='.$user['ID'].'" class ="bg-light rounded my-3"> Voir le profil</a>
                        
                    </div>
                  </div>';
        }
    ?>
    </div>

<?php
}else{
    header("Location: login.php");
}
?>


<script src="ressources/js/user.js"></script>