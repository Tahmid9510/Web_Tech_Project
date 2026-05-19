<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once '../model/config.php';
require_once '../control/CartController.php';

$controller = new CartController($conn);
$controller->showCart($_SESSION["user_id"]);