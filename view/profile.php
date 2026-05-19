<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
}
?>
<html>
<head>
    <title>Profile - StyleNest</title>
    <link rel="stylesheet" type="text/css" href="../public/css/mystyle.css" />
</head>
<body>


<div class="navbar">
    <a href="../view/Home.php" class="logo">StyleNest</a>
    <div class="nav-links">
        <a href="../view/cart.php">My Bag</a>
        <a href="../view/history.php">Orders</a>
        <a href="../view/profile.php">Profile</a>
    </div>
</div>

<div class="page-container">

    <h1 class="page-title">My Profile</h1>

    <div class="profile-container">

        <div class="card">
            <div class="order-info-grid">
                <div>
                    <div class="info-label">Username</div>
                    <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                </div>
                <div>
                    <div class="info-label">Account Status</div>
                    <div class="info-value"><span class="badge badge-confirmed">Active</span></div>
                </div>
            </div>
        </div>

        <div class="section-header">
            <span class="step-number">⚡</span> QUICK LINKS
        </div>
        <div class="card-no-pad">
            <div class="card-body">
                <div class="payment-option">
                    <a href="../view/cart.php" class="payment-option-link">🛒 &nbsp; View My Bag</a>
                </div>
                <div class="payment-option">
                    <a href="../view/history.php" class="payment-option-link">📦 &nbsp; Purchase History</a>
                </div>
                <div class="payment-option">
                    <a href="../view/login.php" class="payment-option-link logout-link">🚪 &nbsp; Logout</a>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
