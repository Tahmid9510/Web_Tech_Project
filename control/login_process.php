<?php

include '../model/db_conn.php';

session_start();

$emailError = "";
$passwordError = "";
$errorMsg = "";

$email = "";

if (isset($_POST["login"])) {

    $hasError = false;

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Email validation
    if (empty($email)) {
        $emailError = "Email is required";
        $hasError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
        $hasError = true;
    }

    // Password validation
    if (empty($password)) {
        $passwordError = "Password is required";
        $hasError = true;
    }

    if ($hasError === false) {

        $mydb = new MyDB();
        $conn = $mydb->createConn();

        $user = $mydb->getUserByEmail($email, $conn);

        if ($user) {

            if (password_verify($password, $user["password_hash"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["role"] = $user["role"];

                header("Location: profile.php");
                exit();

            } else {
                $errorMsg = "Invalid password";
            }

        } else {
            $errorMsg = "Invalid email or password";
        }

        $mydb->closeConn($conn);
    }
}

?>