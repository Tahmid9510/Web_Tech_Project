<?php
require_once '../model/config.php';
require_once '../model/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ProductModel($conn);
    }

    // Load one product and show the details page
    public function showProduct($id) {
        $id = (int)$id;

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "<p style='text-align:center;padding:40px'>Product not found.</p>";
            exit;
        }

        // $product is now available in the view file below
        require_once '../view/product_details.php';
    }
}