<?php
    include "../model/db_conn.php";
    session_start();

    $myDB = new myDB();
    $conn = $myDB->createConn();

    $totalProducts = $myDB->getCount($conn, "products");
    $totalCustomers = $myDB->getCount($conn, "users", "role = ?", ["customer"], "s");
    $totalOrders = $myDB->getCount($conn, "orders");
    $pendingOrders = $myDB->getCount($conn, "orders", "status = ?", ["pending"], "s");

    
?>