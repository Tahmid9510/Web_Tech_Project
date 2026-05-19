<?php
    include "../model/db_conn.php";

    $myDB = new myDB();
    $conn = $myDB->createConn();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['delete_id'])) {
            $myDB->deleteCustomer($conn, $_POST['delete_id']);
            header("Location: admin_customers.php");
            exit;
        }
    }

    $customers = $myDB->getAllCustomers($conn);

?>