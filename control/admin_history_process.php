<?php
    include "../model/db_conn.php";
    session_start();

    $myDB = new myDB();
    $conn = $myDB->createConn();

    $sales = $myDB->getSalesHistory($conn);
    $myDB->closeConn($conn);
?>