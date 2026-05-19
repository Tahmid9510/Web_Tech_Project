<?php
require_once __DIR__ . '/../model/config.php';
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../model/ProductModel.php';

class CartController {
    private $cartModel;
    private $productModel;

    public function __construct($conn) {
        $this->cartModel    = new CartModel($conn);
        $this->productModel = new ProductModel($conn);
    }

    public function addToCart($user_id, $product_id, $quantity) {
        $product_id = (int)$product_id;
        $quantity   = (int)$quantity;

        if ($quantity < 1) {
            return ['success' => false, 'message' => 'Invalid quantity.'];
        }

        $product = $this->productModel->getProductById($product_id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }
        if ($product['stock'] < $quantity) {
            return ['success' => false, 'message' => 'Not enough stock.'];
        }

    
        $existing = $this->cartModel->getCartItem($user_id, $product_id);
        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $this->cartModel->updateQuantity($existing['id'], $newQty);
        } else {
            $this->cartModel->addItem($user_id, $product_id, $quantity);
        }

        return [
            'success'    => true,
            'message'    => 'Added to cart!',
            'cart_count' => $this->cartModel->getCartCount($user_id)
        ];
    }

    public function updateQuantity($user_id, $cart_id, $quantity) {
        $quantity = (int)$quantity;
        if ($quantity < 1) {
            return ['success' => false, 'message' => 'Minimum quantity is 1.'];
        }
        $this->cartModel->updateQuantity((int)$cart_id, $quantity);
        return [
            'success'    => true,
            'cart_count' => $this->cartModel->getCartCount($user_id)
        ];
    }

    public function removeFromCart($user_id, $cart_id) {
    $this->cartModel->removeItem((int)$cart_id, $user_id);

    return [
        'success' => true,
        'cart_count' => $this->cartModel->getCartCount($user_id)
    ];
}

    public function showCart($user_id) {
        $cartItems = $this->cartModel->getCartItems($user_id);
        require_once '../view/cart.php';
    }
}