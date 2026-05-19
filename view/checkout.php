<?php
include '../control/checkout_process.php';
?>
<html>
<head>
    <title>Checkout - StyleNest</title>
    <link rel="stylesheet" type="text/css" href="../public/css/mystyle.css" />
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="../view/Home.php" class="logo">StyleNest</a>
    <div class="nav-links">
        <a href="../view/cart.php">My Bag</a>
        <a href="../view/history.php">Orders</a>
        <a href="../view/profile.php">Profile</a>
    </div>
</div>

<div class="page-container">

    <h1 class="page-title">Checkout</h1>

    <?php if(!empty($errorMsg)): ?>
        <div class="alert-error"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <?php if(count($cartItems) == 0): ?>
        <div class="card empty-state">
            <p>Your cart is empty.</p>
            <a href="../view/Home.php" class="btn btn-primary">GO SHOPPING</a>
        </div>
    <?php else: ?>

    <div class="checkout-layout">

        <!-- LEFT: Shipping + Payment -->
        <div class="checkout-main">

            <form action="" method="post" onsubmit="return validateCheckout()">

                <!-- Section 1: Shipping Address -->
                <div class="section-header">
                    <span class="step-number">1</span> SHIPPING ADDRESS
                </div>
                <div class="card-no-pad">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Delivery Address <span class="required">*</span></label>
                            <textarea id="address" name="address" rows="3" placeholder="Enter your full delivery address"></textarea>
                            <span id="address_err" class="error-msg"></span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Payment Method -->
                <div class="section-header">
                    <span class="step-number">2</span> PAYMENT METHOD
                </div>
                <div class="card-no-pad">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Payment Method <span class="required">*</span></label>
                            <select id="payment_method" name="payment_method">
                                <option value="">-- Select --</option>
                                <option value="Credit Card">Debit/Credit cards</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                            </select>
                            <span id="payment_err" class="error-msg"></span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <a href="../view/cart.php" class="btn btn-secondary">CANCEL</a>
                    <input type="submit" name="place_order" value="PLACE ORDER" class="btn btn-primary">
                </div>

            </form>

        </div>

        <!-- RIGHT: Order Review Sidebar -->
        <div class="checkout-sidebar">

            <div class="section-header">
                <span class="step-number">3</span> ORDER REVIEW
            </div>
            <div class="card-no-pad">
                <div class="card-body">

                    <!-- Product column headers -->
                    <div class="summary-row" style="font-size:11px; text-transform:uppercase; letter-spacing:0.5px; color:#888; font-weight:600;">
                        <span>Product</span>
                        <span>Subtotal</span>
                    </div>

                    <!-- Each product -->
                    <?php foreach($cartItems as $item): ?>
                    <div class="order-product">
                        <img src="../public/uploads/<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="order-product-info">
                            <h4><?php echo htmlspecialchars($item["name"]); ?></h4>
                            <p class="meta">Quantity: <?php echo (int)$item["quantity"]; ?></p>
                        </div>
                        <span class="subtotal">Tk <?php echo number_format($item["price"] * $item["quantity"], 2); ?></span>
                    </div>
                    <?php endforeach; ?>

                    <hr class="divider">

                    <!-- Summary -->
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Tk <?php echo number_format($totalAmount, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>TOTAL</span>
                        <span class="price-orange">Tk <?php echo number_format($totalAmount, 2); ?></span>
                    </div>

                </div>
            </div>

            <!-- Disclaimers -->
            <div class="disclaimers">
                <h4>Checkout Disclaimers:</h4>
                <p>1. No return or exchange shall be applicable for any discounted sale items.</p>
                <p>2. Your order may arrive in multiple shipments depending on warehouse locations.</p>
                <p>3. For Cash on Delivery (COD) orders, make payment only after receiving the product.</p>
                <p style="color:#e67e22; margin-top:8px;">By clicking "Place Order", you agree to our Terms & Conditions.</p>
            </div>

        </div>

    </div>

    <?php endif; ?>

</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
