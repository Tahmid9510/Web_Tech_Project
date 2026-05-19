<?php
session_start();
include '../model/mydb.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    
    $mydb = new MyDB();
    $conn = $mydb->createConn();
    
    $_SESSION['username'] = $username;
    
    $mydb->closeConn($conn);
    header("Location: ../view/cart.php");
    exit();
}
?>
<html>
<head>
    <title>Sign In - StyleNest</title>
    <link rel="stylesheet" type="text/css" href="../public/css/mystyle.css" />
</head>
<body>


<div class="navbar">
    <a href="../view/Home.php" class="logo">StyleNest</a>
    <div class="nav-links">
        <a href="../view/Home.php">Home</a>
        <a href="../view/login.php">Login</a>
    </div>
</div>


<div class="login-container">
    <h1 class="page-title">Sign in</h1>

    <div class="card">
        <form method="post">
            <div class="form-group">
                <label>USERNAME</label>
                <input type="text" name="username" value="testuser" required>
            </div>

            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" value="123">
            </div>

            <div class="form-group">
                <input type="submit" name="login" value="SIGN IN" class="btn btn-login">
            </div>

            <p class="text-center" style="font-size:13px; color:#888;">
                Don't have an account? <a href="#" style="color:#8b2500; font-weight:600;">Create account</a>
            </p>
        </form>
    </div>
</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
