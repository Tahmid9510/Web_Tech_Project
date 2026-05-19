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

$result = $mydb->getOrderById($order_id, $conn);
if($result->num_rows > 0){
    foreach($result as $row){
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
