<?php
include '../model/mydb.php';
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["username"])){
echo json_encode(["error" => "Unauthorized"]);
exit();
}

if(!isset($_GET["order_id"])){
echo json_encode(["error" => "Order ID required"]);
exit();
}

$order_id = (int)$_GET["order_id"];

$mydb = new MyDB();
$conn = $mydb->createConn();

$result = $mydb->getOrderStatus($order_id, $conn);
if($result->num_rows > 0){
    foreach($result as $row){
        echo json_encode($row);
    }
} else {
    echo json_encode(["error" => "Order not found"]);
}

$mydb->closeConn($conn);
?>
