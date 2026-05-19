<?php
require_once '../model/config.php';
require_once '../model/ProductModel.php';

class SearchController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ProductModel($conn);
    }

    // Search and return matching products
    public function search($q, $category, $gender) {
        $q        = trim(htmlspecialchars($q));
        $category = trim($category);
        $gender   = in_array($gender, ['Men', 'Women']) ? $gender : '';

        return $this->productModel->searchProducts($q, $category, $gender);
    }

    // Return all categories
    public function getCategories() {
        return $this->productModel->getAllCategories();
    }
}