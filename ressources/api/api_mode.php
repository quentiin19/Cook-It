<?php
require '../../functions.php';
header("Content-type: application/json");

$pdo = connectDB();

$action = $_GET['action'];
$id = $_GET['id'];


function returnMode($id){
    $query = $pdo->prepare("SELECT MODE FROM USER WHERE ID = :id;");
    $query->execute(['id'=>$id]);
    $result = $query->fetch();

    return json_encode($result);
}

function changeMode($id){
    $mode = returnMode($id);

    if($mode == 1){
        $query = $pdo->prepare("UPDATE USER SET MODE = 0 WHERE ID = :id;");
        $query->execute(['id'=>$id]);
        return json_encode(0);
    }else{
        $query = $pdo->prepare("UPDATE USER SET MODE = 1 WHERE ID = :id;");
        $query->execute(['id'=>$id]);
        return json_encode(1);
    }
}


if($action == 'change'){
    echo changeMode($id)
}elseif ($action == 'get') {
    echo returnMode($id);
}