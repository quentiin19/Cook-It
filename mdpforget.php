<?php
require "./template/header.php";
?>
<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center h-auto arrondie  ">
    <div class="container py-2  h-auto  ">
        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="card bg-color text-white" style="border-radius: 1rem;">
                <div class="card-body  text-center">
                    <div class="mb-md-5 mt-md-4 pb-5">

                        <h2 class="fw-bold mb-2 text-uppercase">Problèmes de connexion ?</h2>
                        <p class="text-white-50 mb-5"> Entrez votre adresse mail et nous vous enverrons un lien pour récupérer votre compte.</p>
                         
                            <div class="col-lg-6 col-md-12 col-sm-12">

                                <form method="POST" action="">
                                    <input type="password" class="form-control" name="password" placeholder="Votre Mot de passe" required="required"><br>
                                    <input type="password" class="form-control" name="passwordconfirm" placeholder="Confirmez votre Mot de passe" required="required"><br>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-1 col-sm-0"></div>
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <input type="submit" class="btn btn-outline-light btn-lg py-2 " value="Envoyer">
                                        </div>
                                        <div class="col-lg-4 col-md-1 col-sm-0"></div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
<?php

//vérification des entrées
if (!empty($_POST["password"]) || !empty($_POST["passwordConfirm"]) || count($_POST) == 2) {
    $pdo = connectDB();
    $pwd = password_hash($_POST["password"], PASSWORD_DEFAULT);

    //si la clé correspond bien
    if ($_GET['cle'] == $_SESSION['cle']) {
        //on update l'entrée en base de données
        $queryPrepared = $pdo->prepare("UPDATE USER set HASHPWD = :pwd WHERE MAIL =:email;");
        $queryPrepared->execute(["pwd" => $pwd, "email" => $_SESSION['email']]);

        echo "Vous avez bien changé votre mot de passe, cliquez sur le lien ci dessous pour vous connecter";
        echo "<br/><a href=http://51.255.172.36/login.php>Se Connecter</a>";
    
    //affichage des erreurs
    } else {
        echo "votre lien n'est plus valide";
        echo 'clé get :' . $_GET['cle'];
        echo 'clé session :' . $_SESSION['cle'];
    }
}

?>