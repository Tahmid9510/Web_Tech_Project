<?php

class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function searchProducts($q = '', $category = '', $gender = '') {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE 1=1";
        $params = [];

        if ($q !== '') {
            $sql .= " AND p.name LIKE :q";
            $params[':q'] = '%' . $q . '%';
        }
        if ($category !== '') {
            $sql .= " AND p.category_id = :category";
            $params[':category'] = $category;
        }
        if ($gender !== '') {
            $sql .= " AND p.gender = :gender";
            $params[':gender'] = $gender;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.name AS category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCategories() {
        $stmt = $this->conn->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}