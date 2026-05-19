<?php
include '../model/mydb.php';
session_start();

if(!isset($_SESSION["username"])){
header("Location: ../view/login.php");
exit();
}

$errorMsg = "";
$cartItems = [];
$totalAmount = 0;

$mydb = new MyDB();
$conn = $mydb->createConn();


$userResult = $mydb->getUser($_SESSION["username"], $conn);
$user_id = null;
if($userResult->num_rows > 0){
    foreach($userResult as $row){
        $user_id = $row["id"];
    }
}

$cartResult = $mydb->getCartByUser($user_id, $conn);
if($cartResult->num_rows > 0){
    foreach($cartResult as $row){
        $cartItems[] = $row;
        $totalAmount += $row["price"] * $row["quantity"];
    }
}


if(isset($_POST["place_order"])){
    $payment_method = trim($_REQUEST["payment_method"]);
    $address = trim($_REQUEST["address"]);

    $hasError = false;

    if(empty($cartItems)){
        $hasError = true;
        $errorMsg = "Your cart is empty.";
    }
    if(empty($payment_method)){
        $hasError = true;
        $errorMsg = "Please select a payment method.";
    }
    if(empty($address)){
        $hasError = true;
        $errorMsg = "Delivery address is required.";
    }

    if($hasError == false){
        $order_id = $mydb->createOrder($user_id, $totalAmount, $conn);

        if($order_id){
            foreach($cartItems as $item){
                $mydb->createOrderItem($order_id, $item["product_id"], $item["quantity"], $item["price"], $conn);
            }

            $transaction_id = "TXN" . strtoupper(uniqid());
            $mydb->createPayment($order_id, $totalAmount, $payment_method, $transaction_id, $conn);

            $mydb->clearCart($user_id, $conn);
            $mydb->closeConn($conn);

            header("Location: ../view/order_confirmation.php?order_id=" . $order_id);
            exit();
        } else {
            $errorMsg = "Error: " . $conn->error;
        }
    }
}
?>
