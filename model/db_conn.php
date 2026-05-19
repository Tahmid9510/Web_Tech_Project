<?php

class myDB{
    
    function createConn(){
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "clothing_store";

        $conn = new mysqli($host, $user, $password, $database);
        return $conn;
    }

    function insertProduct($conn, $name, $description, $size_chart, $price, $category_id, $image_path, $stock, $gender){
        $sql = "INSERT INTO products (name, description, size_chart, price, category_id, image_path, stock, gender, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        // Prepare
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssis", $name, $description, $size_chart, $price, $category_id, $image_path, $stock, $gender);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    function getCount($conn, $table, $condition = "", $params = [], $types = ""){
        $sql = "SELECT COUNT(*) AS total FROM $table";
        if(!empty($condition)) {
            $sql .= " WHERE $condition";
        }
        // Prepare statement
        $stmt = $conn->prepare($sql);
        if(!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['total'];
    }

    function getAllProducts($conn) {
        $sql = "SELECT id, name, price, stock, gender, image_path FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getAll($conn, $table) {
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getProductById($conn, $id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function deleteProduct($conn, $id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    function updateProduct($conn, $data, $imagePath = null) {
        $sql = "UPDATE products SET name=?, price=?, category_id=?, stock=?, gender=?, size_chart=?, description=?";
        if($imagePath !== null) {
            $sql .= ", image_path=?";
        }
        $sql .= " WHERE id=?";
        $stmt = $conn->prepare($sql);
        if($imagePath !== null) {
            $stmt->bind_param("sssissssi", $data['name'], $data['price'], $data['category_id'], $data['stock'], $data['gender'], $data['size_chart'], $data['description'], $imagePath, $data['id']);
        } 
        else {
            $stmt->bind_param("sssisssi", $data['name'], $data['price'], $data['category'], $data['stock'], $data['gender'], $data['size_chart'], $data['description'], $data['id']);
        }

        return $stmt->execute();
    }


    function closeConn($conn){
        $conn->close();
    }

}

?>