<?php
include '../model/mydb.php';
session_start();

if(!isset($_SESSION["username"])){
header("Location: ../view/login.php");
exit();
}

$order = null;
$orderItems = [];
$payment = null;

if(!isset($_GET["order_id"])){
header("Location: ../view/history.php");
exit();
}

$order_id = (int)$_GET["order_id"];

$mydb = new MyDB();
$conn = $mydb->createConn();
$userResult = $mydb->getUser($_SESSION["username"], $conn);
$user_id = null;
if($userResult->num_rows > 0){
    foreach($userResult as $row){
        $user_id = $row["id"];
    }
}

$result = $mydb->getOrderById($order_id, $conn);
if($result->num_rows > 0){
    foreach($result as $row){
        if($row["user_id"] != $user_id){
            header("Location: ../view/history.php");
            exit();
        }
        $order = $row;
    }
}

$itemResult = $mydb->getOrderItems($order_id, $conn);
foreach($itemResult as $item){
    $orderItems[] = $item;
}

$payResult = $mydb->getPaymentByOrder($order_id, $conn);
if($payResult->num_rows > 0){
    foreach($payResult as $p){
        $payment = $p;
    }
}

$mydb->closeConn($conn);
?>
