<?php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'Please login first.']);
    exit;
}

require_once __DIR__ . '/../../model/config.php';
require_once __DIR__ . '/../../control/CartController.php';

$controller = new CartController($conn);
$user_id    = $_SESSION["user_id"];
$action     = $_POST['action'] ?? '';

if ($action === 'add') {
    $product_id = $_POST['product_id'] ?? 0;
    $quantity   = $_POST['quantity']   ?? 1;
    echo json_encode($controller->addToCart($user_id, $product_id, $quantity));

} elseif ($action === 'update') {
    $cart_id  = $_POST['cart_id']  ?? 0;
    $quantity = $_POST['quantity'] ?? 1;
    echo json_encode($controller->updateQuantity($user_id, $cart_id, $quantity));

} elseif ($action === 'remove') {
    $cart_id = $_POST['cart_id'] ?? 0;
    echo json_encode($controller->removeFromCart($user_id, $cart_id));

} else {
    echo json_encode(['success' => false, 'message' => 'Unknown action.']);
}