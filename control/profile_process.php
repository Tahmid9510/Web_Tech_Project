<?php

include '../model/db_conn.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

/*
    Error and success messages
*/
$nameError = "";
$phoneError = "";
$emailError = "";
$addressError = "";
$profilePictureError = "";

$currentPasswordError = "";
$newPasswordError = "";
$confirmPasswordError = "";

$successMsg = "";
$errorMsg = "";

/*
    Default form values
*/
$name = "";
$phone = "";
$email = "";
$address = "";
$profilePicture = "";

$userId = $_SESSION["user_id"];

$mydb = new MyDB();
$conn = $mydb->createConn();

/*
    Load logged-in user data
*/
$user = $mydb->getUserById($userId, $conn);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$name = $user["name"];
$phone = $user["phone"];
$email = $user["email"];
$address = $user["address"];
$profilePicture = $user["profile_picture"];


/*
    Update profile information
*/
if (isset($_POST["update_profile"])) {

    $hasError = false;

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);

    /*
        Server-side validation
    */
    if (empty($name)) {
        $nameError = "Name is required";
        $hasError = true;
    }

    if (empty($phone)) {
        $phoneError = "Phone is required";
        $hasError = true;
    }

    if (empty($email)) {
        $emailError = "Email is required";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $hasError = true;
    }

    if (empty($address)) {
        $addressError = "Address is required";
        $hasError = true;
    }

    /*
        Check if email is already used by another user
    */
    if ($hasError === false) {
        $emailExists = $mydb->isEmailUsedByAnotherUser($email, $userId, $conn);

        if ($emailExists) {
            $emailError = "This email is already used by another account";
            $hasError = true;
        }
    }

    /*
        Profile picture upload validation
    */
    $newProfilePicture = $profilePicture;

    if (!empty($_FILES["profile_picture"]["name"])) {

        $fileName = $_FILES["profile_picture"]["name"];
        $fileTmpName = $_FILES["profile_picture"]["tmp_name"];
        $fileSize = $_FILES["profile_picture"]["size"];
        $fileError = $_FILES["profile_picture"]["error"];

        $allowedTypes = ["image/jpeg", "image/png", "image/webp"];
        $maxFileSize = 2 * 1024 * 1024;

        if ($fileError !== 0) {
            $profilePictureError = "Error uploading profile picture";
            $hasError = true;
        } else {
            $fileMimeType = mime_content_type($fileTmpName);

            if (!in_array($fileMimeType, $allowedTypes)) {
                $profilePictureError = "Only JPG, PNG, and WEBP images are allowed";
                $hasError = true;
            } elseif ($fileSize > $maxFileSize) {
                $profilePictureError = "Profile picture must be less than 2 MB";
                $hasError = true;
            } else {
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $newProfilePicture = time() . "_" . uniqid() . "." . $fileExtension;

                $uploadFolder = "../public/uploads/";

                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }

                $uploadPath = $uploadFolder . $newProfilePicture;

                if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                    $profilePictureError = "Failed to upload profile picture";
                    $hasError = true;
                }
            }
        }
    }

    /*
        Update database
    */
    if ($hasError === false) {

        if (!empty($_FILES["profile_picture"]["name"])) {
            $result = $mydb->updateUserProfileWithPicture(
                $userId,
                $name,
                $email,
                $address,
                $phone,
                $newProfilePicture,
                $conn
            );
        } else {
            $result = $mydb->updateUserProfile(
                $userId,
                $name,
                $email,
                $address,
                $phone,
                $conn
            );
        }

        if ($result === true) {
            $_SESSION["name"] = $name;
            $successMsg = "Profile updated successfully";

            $user = $mydb->getUserById($userId, $conn);

            $name = $user["name"];
            $phone = $user["phone"];
            $email = $user["email"];
            $address = $user["address"];
            $profilePicture = $user["profile_picture"];
        } else {
            $errorMsg = "Profile update failed. Please try again.";
        }
    }
}


/*
    Update password
*/
if (isset($_POST["update_password"])) {

    $hasError = false;

    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($currentPassword)) {
        $currentPasswordError = "Current password is required";
        $hasError = true;
    }

    if (empty($newPassword)) {
        $newPasswordError = "New password is required";
        $hasError = true;
    } elseif (strlen($newPassword) < 8) {
        $newPasswordError = "Password must be at least 8 characters";
        $hasError = true;
    }

    if (empty($confirmPassword)) {
        $confirmPasswordError = "Confirm password is required";
        $hasError = true;
    } elseif ($newPassword !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match";
        $hasError = true;
    }

    if ($hasError === false) {

        if (!password_verify($currentPassword, $user["password_hash"])) {
            $currentPasswordError = "Current password is incorrect";
            $hasError = true;
        }
    }

    if ($hasError === false) {

        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $result = $mydb->updateUserPassword(
            $userId,
            $newPasswordHash,
            $conn
        );

        if ($result === true) {
            $successMsg = "Password updated successfully";
        } else {
            $errorMsg = "Password update failed. Please try again.";
        }
    }
}

$mydb->closeConn($conn);

?>