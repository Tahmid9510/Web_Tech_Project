<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION["user_id"]);
$role = $isLoggedIn ? $_SESSION["role"] : "guest";

$cartCount = 0;

if ($isLoggedIn) {

    include __DIR__ . '/../model/config.php';
    require_once __DIR__ . '/../model/CartModel.php';

    $cartModel = new CartModel($conn);
    $cartCount = $cartModel->getCartCount($_SESSION["user_id"]);
}
?>

<link rel="stylesheet" href="../public/css/nav_footer.css">

<nav class="main-navbar">

    <div class="nav-logo">
        <a href="home.php">StyleNest</a>
    </div>

    <div class="nav-links">
        

        <?php if ($role === "customer") { ?>
            <a href="orders.php">My Orders</a>
        <?php } ?>

        <?php if ($role === "admin") { ?>
            <a href="admin_dashboard.php" class="admin-link">Admin</a>
        <?php } ?>
    </div>

    

    <div class="nav-account">

        <?php if ($isLoggedIn) { ?>

            <a href="cart_page.php" class="account-link">
                Cart (<span id="cartBadge"><?= $cartCount ?></span>)
            </a>

            <a href="profile.php" class="account-link">Profile</a>

            <a href="../control/logout_process.php" class="account-link">
                Logout
            </a>

        <?php } else { ?>

            <a href="login.php" class="account-link">Login</a>

            <a href="registration.php" class="signup-btn">
                Sign Up
            </a>

        <?php } ?>

    </div>
    <script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const saved = localStorage.getItem('cartCount');
        if (saved !== null) {
            const badge = document.getElementById('cartBadge');
            if (badge) badge.textContent = saved;
        }
    });
</script>

</nav>