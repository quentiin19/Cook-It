<?php
include "template/header.php";




if (isConnected()) {
    $pdo = connectDB();

    $queryPrepared = $pdo->prepare("SELECT * FROM USER");
    $queryPrepared->execute();
    $results = $queryPrepared->fetchAll();
?>


    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
            </tr>
        </thead>
        <tbody>

        <?php
        foreach ($results as $user) {
            if ($user['ID'] != $_SESSION['id']) {
                echo '  <tr>
                    <td>' . $user["LASTNAME"] . '</td>
                    <td>' . $user["FIRSTNAME"] . '</td>
                    <td>' . $user["PSEUDO"] . '</td>
                    <td>
                        <div class="btn-group">
                            <a href="message.php?id=' . $user["ID"] . '" class="btn btn-primary">Message</a>
                        </div>
                    </td>
                </tr>';
            }
        }
    }
        ?>