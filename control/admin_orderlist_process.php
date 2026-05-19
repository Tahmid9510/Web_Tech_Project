<?php
    include "../model/db_conn.php";

    $myDB = new myDB();
    $conn = $myDB->createConn();

    $orders = $myDB->getAllOrders($conn);

    if(isset($_GET['id']) && isset($_GET['status'])){
        $id = $_GET['id'];
        $status = $_GET['status'];
        $sql = "SELECT status FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row && $row['status'] == "pending") {
            $myDB->updateOrderStatus($conn, $id, $status);
            echo "success";
        } 
        else {
            echo "Order already " . ($row['status'] ?? 'unknown');
        }
    }
?>