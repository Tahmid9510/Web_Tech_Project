<?php

include '../model/db_conn.php';

function showProductImage($imagePath)
{
    if (!empty($imagePath)) {
        if (strpos($imagePath, 'public/') === 0) {
            return '../' . $imagePath;
        } else {
            return '../public/image/' . $imagePath;
        }
    }

    return '../public/image/product-placeholder.png';
}

$mydb = new MyDB();
$conn = $mydb->createConn();

$featuredProducts = $mydb->getFeaturedProducts($conn);

$mydb->closeConn($conn);

?>