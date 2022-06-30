<?php
include '../../template/header.php';


$pdo = connectDB();
//Verification que l'un est bien abonné à l'autre
$queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
$queryPrepared->execute(["sender"=>$_SESSION['id'], "receveur"=>$_GET['id']]);
$state1 = $queryPrepared->fetch();

//vérification que l'autre est bien abonné à l'un
$queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
$queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
$state2 = $queryPrepared->fetch();

if($state1[0] == 1 && $state2[0] == 1){
    if(isConnected()){
        echo '<p id="id-sender" hidden="hidden">'.$_SESSION['id'].'</p>';
        echo '<p id="id-receveur" hidden="hidden">'.$_GET['id'].'</p>';
        echo '<p id="token" hidden="hidden">'.$_SESSION['token'].'</p>';
    }
    
    $queryPrepared = $pdo->prepare("SELECT PSEUDO FROM USER WHERE ID = :id;");
    $queryPrepared->execute(['id'=>$_GET['id']]);
    $friendName = $queryPrepared->fetch();
    
    ?>
    
    
    
    
    <div class="row d-flex justify-content-center my-5">
        <div class="col-md-10 col-lg-8 col-xl-6">
    
            <div class="card" id="chat2">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <h5 class="mb-0">Chatter avec <?= $friendName[0] ?></h5>
                </div>
    
    
                <!-- section du chat -->
    
    
                <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
              
              
                    <!-- 1ere personne -->
                    <div class="d-flex flex-row justify-content-start">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                        <div>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are you ...???</p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are you doing tomorrow? Can we come up a bar?</p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                        </div>
                    </div>

                    
                    <!-- 2eme personne -->
                    <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                        <div>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Hiii, I'm good.</p>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">How are you doing?</p>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Long time no see! Tomorrow office. will be free on sunday.</p>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
                        </div>
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>

                </div>


                <!-- section du chat -->
    
    
                <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                    <input type="text" class="form-control form-control-lg" id="message-input" placeholder="Type message">
                    <button id="send-message">envoyer</button>
                    <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                </div>
            </div>
    
        </div>
    </div>
    
    
    
    <div id="message-canva"></div>
    <input type="text" id="message-input">
    <button id="send-message">envoyer</button>
    
    <script src="messagerie.js"></script>
<?php
}else{
    echo 'vous n\'etes pas amis avec cette personnes !';
    echo '<br>';
    echo '<a href="index.php">Acceuil</a>';
}

?>