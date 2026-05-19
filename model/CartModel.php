<?php
// Handles all database queries for the cart

class CartModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all cart items for a user (with product info)
    public function getCartItems($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT cart.id, cart.quantity, cart.product_id,
                    products.name, products.price, products.image_path, products.stock
             FROM cart
             JOIN products ON cart.product_id = products.id
             WHERE cart.user_id = :user_id"
        );
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check if this product is already in the cart
    public function getCartItem($user_id, $product_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id"
        );
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert a new cart item
    public function addItem($user_id, $product_id, $quantity) {
        $stmt = $this->conn->prepare(
            "INSERT INTO cart (user_id, product_id, quantity) 
             VALUES (:user_id, :product_id, :quantity)"
        );
        return $stmt->execute([
            ':user_id'    => $user_id,
            ':product_id' => $product_id,
            ':quantity'   => $quantity
        ]);
    }

    // Update quantity of a cart row
    public function updateQuantity($cart_id, $quantity) {
        $stmt = $this->conn->prepare(
            "UPDATE cart SET quantity = :quantity WHERE id = :id"
        );
        return $stmt->execute([':quantity' => $quantity, ':id' => $cart_id]);
    }

    // Delete a cart item
    public function removeItem($cart_id, $user_id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM cart WHERE id = :id AND user_id = :user_id"
        );
        return $stmt->execute([':id' => $cart_id, ':user_id' => $user_id]);
    }

    // Count total items in cart (for the badge number)
    public function getCartCount($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT SUM(quantity) AS total FROM cart WHERE user_id = :user_id"
        );
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }
}