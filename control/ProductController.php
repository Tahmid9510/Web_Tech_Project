<?php
require_once __DIR__ . '/../model/config.php';
require_once __DIR__ . '/../model/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ProductModel($conn);
    }

    public function showProduct($id) {
        $id = (int)$id;

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "<p style='text-align:center;padding:40px'>Product not found.</p>";
            exit;
        }
        require_once '../view/product_details.php';
    }
}