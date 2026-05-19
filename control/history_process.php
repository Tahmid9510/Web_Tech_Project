<?php
include '../model/mydb.php';
session_start();

if(!isset($_SESSION["username"])){
header("Location: ../view/login.php");
exit();
}

$orders = [];

$mydb = new MyDB();
$conn = $mydb->createConn();

$userResult = $mydb->getUser($_SESSION["username"], $conn);
$user_id = null;
if($userResult->num_rows > 0){
    foreach($userResult as $row){
        $user_id = $row["id"];
    }
}

$result = $mydb->getOrdersByUser($user_id, $conn);
if($result->num_rows > 0){
    foreach($result as $row){
        $orders[] = $row;
    }
}

$mydb->closeConn($conn);
?>
