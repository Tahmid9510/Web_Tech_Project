<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../model/config.php';
require_once __DIR__ . '/../../model/ProductModel.php';
require_once __DIR__ . '/../../control/SearchController.php';

$controller = new SearchController($conn);

$action = $_GET['action'] ?? '';

if ($action === 'categories') {
    echo json_encode(['categories' => $controller->getCategories()]);
    exit;
}

$q        = $_GET['q']        ?? '';
$category = $_GET['category'] ?? '';
$gender   = $_GET['gender']   ?? '';

$products = $controller->search($q, $category, $gender);

echo json_encode(['success' => true, 'products' => $products]);