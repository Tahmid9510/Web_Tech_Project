<?php

require_once '../model/config.php';
require_once '../control/ProductController.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$controller = new ProductController($conn);
$controller->showProduct($id);