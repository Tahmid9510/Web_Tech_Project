<?php
require_once __DIR__ . '/../model/config.php';
require_once __DIR__ . '/../model/ProductModel.php';

class SearchController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new ProductModel($conn);
    }

    public function search($q, $category, $gender) {
        $q        = trim(htmlspecialchars($q));
        $category = trim($category);
        $gender   = in_array($gender, ['Men', 'Women']) ? $gender : '';

        return $this->productModel->searchProducts($q, $category, $gender);
    }

    public function getCategories() {
        return $this->productModel->getAllCategories();
    }
}