<?php

$host = "localhost";
$dbname = "clothing_store";
$username = "root";
$password = "";

$conn = new PDO(
    "mysql:host=$host;dbname=$dbname",
    $username,
    $password
);

?>