<?php
require '../../functions.php';
header("Content-type: application/json");

function returnMode($id){
    $pdo = connectDB();
    $query = $pdo->prepare("SELECT MODE FROM USER WHERE ID = :id;");
    $query->execute(['id'=>$id]);
    $result = $query->fetch();

    return json_encode($result);
}

echo returnMode($_GET['id']);