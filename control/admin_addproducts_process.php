<?php

include "../model/db_conn.php";
session_start();

$error = "";
$hasError = false;

$myDB = new myDB();



if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $size_chart = $_POST['size_chart'];
    $price = (int)$_POST['price'];
    $category_id = $_POST['category_id'];
    $stock = (int)$_POST['stock'];
    $gender = $_POST['gender'];

    if(empty($name)) $hasError = true;
    if(empty($description)) $hasError = true;
    if(empty($size_chart)) $hasError = true;
    if(empty($category_id)) $hasError = true;
    if(empty($gender)) $hasError = true;
    if(empty($price) || $price <= 0) $hasError = true;
    if(empty($stock) || $stock <= 0) $hasError = true;


    if(!$hasError){
        // Image Upload
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "../public/uploads/";
        $image_path = $upload_dir . $image_name;
        move_uploaded_file($tmp_name, $image_path);
        
        $conn = $myDB->createConn();
        $sql = "INSERT INTO products (name, description, size_chart, price, category_id, image_path, stock, gender, created_at)
        VALUES
        ('$name', '$description', '$size_chart', '$price', '$category_id', '$image_path', '$stock', '$gender', NOW())";
        
        if($conn->query($sql) === TRUE) {
            // $success = "Product Added Successfully!";
            $_SESSION['success'] = "Product Added Successfully!";
            header("Location: admin_products.php");
            exit();
        }
        else {
            $error = "Error: " . $conn->error;
        }
        $myDB->closeConn($conn);
    }
    else{
        $error = "Invalid Information! Try again";
    }

}



?>