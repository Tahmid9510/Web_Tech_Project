<?php
    include "../model/db_conn.php";
    session_start();

    $myDB = new myDB();
    $conn = $myDB->createConn();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['delete_id'])) {
            $myDB->deleteCustomer($conn, $_POST['delete_id']);
            header("Location: admin_customers.php");
            exit;
        }
    }

    $totalCustomers = $myDB->getCount($conn, "users", "role = ?", ["customer"], "s");
    $customers = $myDB->getAllCustomers($conn);
    
    $myDB->closeConn($conn);
?>