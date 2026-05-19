<?php
// $cartItems comes from CartController::showCart()
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart — Étoffe</title>
    <link rel="stylesheet" href="../public/css/nav_footer.css">
    <link rel="stylesheet" href="../public/css/task3.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="cart-container">
    <h2 class="page-title">
        Your Cart
        <?php if (!empty($cartItems)): ?>
            <span class="item-count">(<?= count($cartItems) ?> item<?= count($cartItems) > 1 ? 's' : '' ?>)</span>
        <?php endif; ?>
    </h2>

    <?php if (empty($cartItems)): ?>
    <!-- Empty cart message -->
    <div class="cart-empty">
        <p>Your cart is empty.</p>
        <a href="home.php" class="btn-primary">Continue Shopping</a>
    </div>

    <?php else: ?>

    <!-- Cart Items Table -->
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="cartBody">
        <?php foreach ($cartItems as $item): ?>
            <tr id="cart-row-<?= $item['id'] ?>">

                <!-- Product name + image -->
                <td>
                    <div class="cart-product-cell">
                        <img src="../public/uploads/products/<?= htmlspecialchars($item['image_path']) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <span><?= htmlspecialchars($item['name']) ?></span>
                    </div>
                </td>

                <!-- Unit price -->
                <td>৳<?= number_format($item['price'], 2) ?></td>

                <!-- Quantity controls -->
                <td>
                    <div class="qty-control">
                        <button class="qty-btn"
                                data-cart-id="<?= $item['id'] ?>"
                                data-action="decrease">−</button>
                        <span id="qty-<?= $item['id'] ?>"><?= (int)$item['quantity'] ?></span>
                        <button class="qty-btn"
                                data-cart-id="<?= $item['id'] ?>"
                                data-action="increase"
                                data-stock="<?= (int)$item['stock'] ?>">+</button>
                    </div>
                </td>

                <!-- Subtotal for this row -->
                <td id="subtotal-<?= $item['id'] ?>"
                    data-price="<?= $item['price'] ?>">
                    ৳<?= number_format($item['price'] * $item['quantity'], 2) ?>
                </td>

                <!-- Remove button -->
                <td>
                    <button class="remove-btn"
                            data-cart-id="<?= $item['id'] ?>">✕</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Order Summary -->
    <div class="cart-summary">
        <h3>Order Summary</h3>
        <div class="summary-row">
            <span>Subtotal</span>
            <span>৳<span id="cartTotal"><?= number_format($total, 2) ?></span></span>
        </div>
        <div class="summary-row">
            <span>Shipping</span>
            <span>Calculated at checkout</span>
        </div>
        <div class="summary-total">
            <span>Total</span>
            <span>৳<span id="cartGrandTotal"><?= number_format($total, 2) ?></span></span>
        </div>
        <!-- Change checkout.php to whatever Task 4 names their file -->
        <a href="checkout.php" class="btn-primary" style="display:block;text-align:center;margin-top:18px;">
            PROCEED TO CHECKOUT
        </a>
        <a href="home.php" class="continue-link">← Continue Shopping</a>
    </div>

    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<script src="../public/js/cart.js"></script>
</body>
</html>