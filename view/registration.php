<?php
include '../control/registration_process.php';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="../public/css/auth.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="auth-page">
    <div class="auth-card">

        <div class="auth-header">
            <h1>Create your account</h1>
        </div>


        <form 
            action="" 
            method="POST" 
            id="registrationForm"
            class="auth-form"
            enctype="multipart/form-data"
        >

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                    >
                    <small class="error-text" id="nameError"><?php echo $nameError; ?></small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                    >
                    <small class="error-text" id="phoneError"><?php echo $phoneError; ?></small>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                >
                <small class="error-text" id="emailError"><?php echo $emailError; ?></small>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                >
                <small class="error-text" id="addressError"><?php echo $addressError; ?></small>
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

            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input 
                    type="file" 
                    id="profile_picture" 
                    name="profile_picture"
                    accept="image/jpeg, image/png, image/webp"
                >
                <small class="error-text" id="profilePictureError"><?php echo $profilePictureError; ?></small>
            </div>

            <div class="form-group">
                <label for="role">Account Type</label>
                <select id="role" name="role">
                    <option value="customer">
                        Customer
                    </option>
                    <option value="admin">
                        Admin
                    </option>
                </select>
                <small class="error-text" id="roleError"><?php echo $roleError; ?></small>
            </div>

            <button type="submit" class="auth-btn" name="register">Create Account</button>

            <p class="auth-link">
                Already have an account?
                <a href="login.php">Sign in</a>
            </p>
        </form>

    </div>
</div>
<?php include 'footer.php'; ?>
<script src="../public/js/script.js"></script>
</body>
</html>