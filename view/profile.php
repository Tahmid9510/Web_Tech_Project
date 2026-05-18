<?php
include '../control/profile_process.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <link rel="stylesheet" href="../public/css/profile.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="profile-page">
    <div class="profile-container">

        <div class="profile-header">
            <p>ACCOUNT</p>
            <h1>Your profile</h1>
        </div>

        <?php if (!empty($successMsg)) { ?>
            <div class="success-box">
                <p><?php echo htmlspecialchars($successMsg); ?></p>
            </div>
        <?php } ?>

        <?php if (!empty($errorMsg)) { ?>
            <div class="error-box">
                <p><?php echo htmlspecialchars($errorMsg); ?></p>
            </div>
        <?php } ?>

        <div class="profile-content">

            <div class="profile-left">
                <div class="profile-photo-circle">
                    <?php if (!empty($profilePicture)) { ?>
                        <img 
                            src="../public/uploads/<?php echo htmlspecialchars($profilePicture); ?>" 
                            alt="Profile Picture"
                        >
                    <?php }?>
                </div>

                <label for="profile_picture" class="profile-upload-btn">
                    Upload Photo
                </label>
            </div>

            <div class="profile-right">

                <h2>Personal details</h2>

                <form 
                    action="" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    id="profileForm"
                    class="profile-form"
                >

                    <input 
                        type="file" 
                        id="profile_picture" 
                        name="profile_picture"
                        accept="image/jpeg, image/png, image/webp"
                        hidden
                    >

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name"
                                value="<?php echo htmlspecialchars($name ?? ''); ?>"
                            >
                            <small class="error-text" id="nameError"><?php echo $nameError ?? ''; ?></small>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone"
                                value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                            >
                            <small class="error-text" id="phoneError"><?php echo $phoneError ?? ''; ?></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="text" 
                            id="email" 
                            name="email"
                            value="<?php echo htmlspecialchars($email ?? ''); ?>"
                        >
                        <small class="error-text" id="emailError"><?php echo $emailError ?? ''; ?></small>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address"
                            value="<?php echo htmlspecialchars($address ?? ''); ?>"
                        >
                        <small class="error-text" id="addressError"><?php echo $addressError ?? ''; ?></small>
                    </div>

                    <button type="submit" class="profile-main-btn" name="update_profile">
                        Save Changes
                    </button>

                </form>

                <div class="profile-divider"></div>

                <h2>Change password</h2>

                <form 
                    action="" 
                    method="POST" 
                    id="passwordForm"
                    class="profile-form"
                >

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password"
                        >
                        <small class="error-text" id="currentPasswordError"><?php echo $currentPasswordError ?? ''; ?></small>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password"
                            >
                            <small class="error-text" id="newPasswordError"><?php echo $newPasswordError ?? ''; ?></small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password"
                            >
                            <small class="error-text" id="confirmPasswordError"><?php echo $confirmPasswordError ?? ''; ?></small>
                        </div>
                    </div>

                    <button type="submit" class="profile-main-btn" name="update_password">
                        Update Password
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>
<?php include 'footer.php'; ?>
<script src="../public/js/script.js"></script>
</body>
</html>