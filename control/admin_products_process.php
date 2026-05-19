<?php
    include "../model/db_conn.php";

    session_start();
    $success = "";
    $error = "";

    if(isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }

    $myDB = new myDB();
    $conn = $myDB->createConn();

    $products = $myDB->getAllProducts($conn);
    $totalProducts = $myDB->getCount($conn, "products");

    if(isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $myDB->deleteProduct($conn, $id);
        header("Location: admin_products.php");
        exit;
    }

?>