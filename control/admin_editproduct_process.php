<?php
    include "../model/db_conn.php";
    session_start();

    $myDB = new myDB();
    $conn = $myDB->createConn();

    $id = $_GET['id'];
    $product = $myDB->getProductById($conn, $id);

    $categories = $myDB->getAll($conn, "categories");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $imagePath = null;
        if(!empty($_FILES['image']['name'])) {
            $imageName = time() . "_" . $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp, "../public/uploads/" . $imageName);
            $imagePath = "../public/uploads/" . $imageName;
        }
        $data = [ 
            "id" => $id, "name" => $_POST['name'], "price" => $_POST['price'], "category_id" => $_POST['category'],
            "stock" => $_POST['stock'], "gender" => $_POST['gender'], "size_chart" => $_POST['size_chart'], "description" => $_POST['description']
        ];
        $myDB->updateProduct($conn, $data, $imagePath);
        header("Location: admin_products.php");
        exit;
    }

    
?>