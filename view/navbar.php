<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION["user_id"]);
$role = $isLoggedIn ? $_SESSION["role"] : "guest";
?>

<link rel="stylesheet" href="../public/css/nav_footer.css">

<nav class="main-navbar">
    <div class="nav-logo">
        <a href="home.php">Étoffe</a>
    </div>

    <div class="nav-links">
        <a href="gender.php?gender=Men">Men</a>
        <a href="gender.php?gender=Women">Women</a>

        <?php if ($role === "customer") { ?>
            <a href="orders.php">My Orders</a>
        <?php } ?>

        <?php if ($role === "admin") { ?>
            <a href="admin_dashboard.php" class="admin-link">Admin</a>
        <?php } ?>
    </div>

    <div class="nav-search">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="nav-account">

        <?php if ($isLoggedIn) { ?>
            <a href="profile.php" class="account-link">Profile</a>
            <a href="../control/logout_process.php" class="account-link">Logout</a>
        <?php } else { ?>
            <a href="login.php" class="account-link">Login</a>
            <a href="registration.php" class="signup-btn">Sign Up</a>
        <?php } ?>
    </div>
</nav>