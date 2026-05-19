<?php
class MyDB {

function createConn(){
$DBHOST = "localhost";
$DBUSER = "root";
$DBPASS = "";
$DBNAME = "clothing _store";
$conn = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
return $conn;
}



function createUser($username, $email, $password,$file,$conn){
$sql="INSERT INTO users (username, email, password, file) VALUES ('$username', '$email', '$password', '$file')";
return $conn->query($sql);
}

function getUser($username, $conn){
$sql="SELECT * FROM users WHERE username='$username' ";
return $conn->query($sql);
}

function updateUser($username, $email, $password,$file,$conn){
$sql="UPDATE users SET email='$email', password='$password', file='$file' WHERE username='$username'";
return $conn->query($sql);
}

function searchUser($username, $conn){
$sql="SELECT * FROM users WHERE username='$username' ";
return $conn->query($sql);
}



function getCartByUser($user_id, $conn){
$sql="SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image_path, p.stock
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = '$user_id'";
return $conn->query($sql);
}

function clearCart($user_id, $conn){
$sql="DELETE FROM cart WHERE user_id = '$user_id'";
return $conn->query($sql);
}



function createOrder($user_id, $total_amount, $conn){
$sql="INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'pending')";
$conn->query($sql);
return $conn->insert_id;
}

function createOrderItem($order_id, $product_id, $quantity, $unit_price, $conn){
$sql="INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES ('$order_id', '$product_id', '$quantity', '$unit_price')";
return $conn->query($sql);
}

function getOrdersByUser($user_id, $conn){
$sql="SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
return $conn->query($sql);
}

function getOrderById($order_id, $conn){
$sql="SELECT * FROM orders WHERE id = '$order_id'";
return $conn->query($sql);
}

function getOrderItems($order_id, $conn){
$sql="SELECT oi.quantity, oi.unit_price, p.name, p.image_path
     FROM order_items oi
     JOIN products p ON oi.product_id = p.id
     WHERE oi.order_id = '$order_id'";
return $conn->query($sql);
}



function createPayment($order_id, $amount, $payment_method, $transaction_id, $conn){
$sql="INSERT INTO payments (order_id, amount, payment_method, transaction_id) VALUES ('$order_id', '$amount', '$payment_method', '$transaction_id')";
return $conn->query($sql);
}

function getPaymentByOrder($order_id, $conn){
$sql="SELECT * FROM payments WHERE order_id = '$order_id'";
return $conn->query($sql);
}



function getOrderStatus($order_id, $conn){
$sql="SELECT id, status, total_amount, order_date FROM orders WHERE id = '$order_id'";
return $conn->query($sql);
}

function closeConn($conn){
$conn->close();
}

}
?>
