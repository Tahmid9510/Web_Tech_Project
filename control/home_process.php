<?php

include '../model/db_conn.php';

$mydb = new MyDB();
$conn = $mydb->createConn();

$featuredProducts = $mydb->getFeaturedProducts($conn);

$mydb->closeConn($conn);

?>