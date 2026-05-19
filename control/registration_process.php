<?php

include '../model/db_conn.php';

$nameError = "";
$phoneError = "";
$emailError = "";
$addressError = "";
$passwordError = "";
$roleError = "";
$profilePictureError = "";
$successMsg = "";
$errorMsg = "";

$name = "";
$phone = "";
$email = "";
$address = "";
$role = "";

if (isset($_POST["register"])) {

    $hasError = false;

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Name validation
    if (empty($name)) {
        $nameError = "Name is required";
        $hasError = true;
    }

    // Phone validation
    if (empty($phone)) {
        $phoneError = "Phone is required";
        $hasError = true;
    }

    // Email validation
    if (empty($email)) {
        $emailError = "Email is required";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $hasError = true;
    }

    // Address validation
    if (empty($address)) {
        $addressError = "Address is required";
        $hasError = true;
    }

    // Password validation
    if (empty($password)) {
        $passwordError = "Password is required";
        $hasError = true;
    } elseif (strlen($password) < 8) {
        $passwordError = "Password must be at least 8 characters";
        $hasError = true;
    }

    // Role validation
    if (empty($role)) {
        $roleError = "Account type is required";
        $hasError = true;
    } elseif ($role !== "admin" && $role !== "customer") {
        $roleError = "Invalid account type";
        $hasError = true;
    }

    $profilePictureName = NULL;

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
            
            $profilePictureName = time() . "_" . uniqid() . "." . $fileExtension;
            $uploadPath = "../public/uploads/" . $profilePictureName;

            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                $profilePictureError = "Failed to upload profile picture";
                $hasError = true;
            }
        }
    }
}

    if ($hasError === false) {

        $mydb = new MyDB();
        $conn = $mydb->createConn();

        // Check duplicate email
        if ($mydb->getUserByEmail($email, $conn)) {
            $emailError = "This email is already registered";
            $hasError = true;
        } else {



            if ($hasError === false) {

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $result = $mydb->createUser(
                    $name,
                    $email,
                    $passwordHash,
                    $role,
                    $profilePictureName,
                    $address,
                    $phone,
                    $conn
                );

                if ($result === true) {
                    header("Location: login.php");
                    exit();
                } else {
                    $errorMsg = "Registration failed. Please try again.";
                }
            }
        }

        $mydb->closeConn($conn);
    }
}

?>
