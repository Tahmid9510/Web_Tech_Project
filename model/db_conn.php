<?php

class MyDB
{
    private $DBHOST = "localhost";
    private $DBUSER = "root";
    private $DBPASS = "";
    private $DBNAME = "clothing_store";

    public function createConn()
    {
        $conn = new mysqli(
            $this->DBHOST,
            $this->DBUSER,
            $this->DBPASS,
            $this->DBNAME
        );

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function createUser($name, $email, $passwordHash, $role, $profilePicture, $address, $phone, $conn)
    {
        $sql = "INSERT INTO users 
                (name, email, password_hash, role, profile_picture, address, phone) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "sssssss",
            $name,
            $email,
            $passwordHash,
            $role,
            $profilePicture,
            $address,
            $phone
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }



    public function getUserByEmail($email, $conn)
    {
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    return $user;
    }

    public function getUserById($userId, $conn)
{
    $sql = "SELECT * FROM users WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();

    return $user;
}


public function isEmailUsedByAnotherUser($email, $userId, $conn)
{
    $sql = "SELECT id FROM users WHERE email = ? AND id != ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("si", $email, $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();

    return $user;
}


public function updateUserProfile($userId, $name, $email, $address, $phone, $conn)
{
    $sql = "UPDATE users 
            SET name = ?, email = ?, address = ?, phone = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param(
        "ssssi",
        $name,
        $email,
        $address,
        $phone,
        $userId
    );

    $result = $stmt->execute();

    $stmt->close();

    return $result;
}


public function updateUserProfileWithPicture($userId, $name, $email, $address, $phone, $profilePicture, $conn)
{
    $sql = "UPDATE users 
            SET name = ?, email = ?, address = ?, phone = ?, profile_picture = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param(
        "sssssi",
        $name,
        $email,
        $address,
        $phone,
        $profilePicture,
        $userId
    );

    $result = $stmt->execute();

    $stmt->close();

    return $result;
}


public function updateUserPassword($userId, $passwordHash, $conn)
{
    $sql = "UPDATE users 
            SET password_hash = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("si", $passwordHash, $userId);

    $result = $stmt->execute();

    $stmt->close();

    return $result;
}

public function getFeaturedProducts($conn)
{
    $sql = "SELECT id, name, price, image_path, gender, category_id 
            FROM products 
            ORDER BY created_at DESC 
            LIMIT 4";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    return $products;
}

    public function closeConn($conn)
    {
        $conn->close();
    }

}

?>