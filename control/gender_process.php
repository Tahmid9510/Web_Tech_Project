<?php

include '../model/db_conn.php';

$allowedGenders = ["Men", "Women"];

$gender = "Men";

if (isset($_GET["gender"]) && in_array($_GET["gender"], $allowedGenders)) {
    $gender = $_GET["gender"];
}

$selectedCategoryId = null;

if (isset($_GET["category_id"]) && is_numeric($_GET["category_id"])) {
    $selectedCategoryId = (int) $_GET["category_id"];
}

$mydb = new MyDB();
$conn = $mydb->createConn();

$parentCategory = $mydb->getParentCategoryByName($gender, $conn);

$categories = [];
$products = [];

if ($parentCategory) {
    $categories = $mydb->getChildCategories($parentCategory["id"], $conn);

    if ($selectedCategoryId !== null) {
        $products = $mydb->getProductsByCategoryAndGender($selectedCategoryId, $gender, $conn);
    } else {
        $products = $mydb->getProductsByGender($gender, $conn);
    }
}

function showProductImage($imagePath)
{
    if (!empty($imagePath)) {
        return '../public/image/' . $imagePath;
    }

    return '../public/image/product-placeholder.png';
}
$mydb->closeConn($conn);

?>