<?php
include '../control/login_process.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="auth-page">
    <div class="auth-card">

        <div class="auth-header">
            <h1>Sign in</h1>
        </div>

        <?php if (!empty($errorMsg)) { ?>
            <div class="error-box">
                <p><?php echo $errorMsg; ?></p>
            </div>
        <?php } ?>

        <form 
            action="" 
            method="POST" 
            id="loginForm"
            class="auth-form"
        >

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                     value="<?php echo htmlspecialchars($email); ?>"
                >
                <small class="error-text" id="emailError"><?php echo $emailError; ?></small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                >
                <small class="error-text" id="passwordError"><?php echo $passwordError; ?></small>
            </div>

            <button type="submit" class="auth-btn" name="login">Sign In</button>

            <p class="auth-link">
                Don’t have an account?
                <a href="registration.php">Create account</a>
            </p>
        </form>

    </div>
</div>
</body>
</html>