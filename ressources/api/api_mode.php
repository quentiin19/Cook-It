<?php
require '../../functions.php';
header("Content-type: application/json");


$action = $_GET['action'];
$id = $_GET['id'];


function returnMode($id){
    $pdo = connectDB();
    $query = $pdo->prepare("SELECT MODE FROM USER WHERE ID = :id;");
    $query->execute(['id'=>$id]);
    $result = $query->fetch();

    $return = array();
    array_push($return, $result[0]);
    echo $return;
    return $return;
}

function changeMode($id){
    $mode = returnMode($id);
    $pdo = connectDB();

    if($mode[0] == 1){
        $query = $pdo->prepare("UPDATE USER SET MODE = 0 WHERE ID = :id;");
        $query->execute(['id'=>$id]);

        $return = array();
        array_push($return, 0);
        
        return $return;
    }else{
        $query = $pdo->prepare("UPDATE USER SET MODE = 1 WHERE ID = :id;");
        $query->execute(['id'=>$id]);

        $return = array();
        array_push($return, 1);
        echo $return;

        return $return;
    }
}


if($action == 'change'){
    echo json_encode(changeMode($id));
}elseif ($action == 'get') {
    echo json_encode(returnMode($id));
}