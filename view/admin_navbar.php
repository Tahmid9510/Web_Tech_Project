<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION["user_id"]);
$name = $isLoggedIn ? $_SESSION["name"] : "guest";
$role = $isLoggedIn ? $_SESSION["role"] : "guest";
$isLoggedIn = "customer";


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}

?>

<link rel="stylesheet" href="../public/css/admin_nav_footer.css">

<nav class="main-navbar">
    <div class="nav-logo">
        <a href="home.php">StyleNest</a>
    </div>

    <div class="nav-links">
        <a href="admin_products.php">Products</a>
        <a href="admin_customers.php">Customers</a>

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

        <?php if($isLoggedIn) { ?>
            <a href="admin_dashboard.php" class="account-link">Dashboard</a>
            <form method="POST">
                <input type="hidden" name="logout" value = "1">
                <button class="logout-btn" onclick="return confirm('Sure you want to logout?')">Logout</button>
            </form>
        <?php } else { ?>
            <a href="login.php" class="account-link">Login</a>
            <a href="registration.php" class="signup-btn">Sign Up</a>
        <?php } ?>
    </div>
</nav>