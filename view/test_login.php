<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["user_id"] = 1;
$_SESSION["role"]    = "customer";
$_SESSION["name"]    = "Test User";

echo "Logged in! <a href='cart_page.php'>Go to Cart</a> | 
      <a href='product_page.php?id=1'>Go to Product</a>";
?>