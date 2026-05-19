<?php
// $product variable comes from ProductController::showProduct()
if (session_status() === PHP_SESSION_NONE) session_start();
$isLoggedIn = isset($_SESSION["user_id"]);
$role       = $isLoggedIn ? $_SESSION["role"] : "guest";
$stock      = (int)$product['stock'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> — Étoffe</title>
    <link rel="stylesheet" href="../public/css/nav_footer.css">
    <link rel="stylesheet" href="../public/css/task3.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="home.php">Home</a> › 
    <a href="gender.php?gender=<?= urlencode($product['gender']) ?>">
        <?= htmlspecialchars($product['gender']) ?>
    </a> › 
    <?= htmlspecialchars($product['name']) ?>
</div>

<!-- Product Layout -->
<div class="product-page">

    <!-- Left: Product Image -->
    <div class="product-image">
        <img src="../public/uploads/products/<?= htmlspecialchars($product['image_path']) ?>"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- Right: Product Info -->
    <div class="product-info">

        <p class="product-meta">
            <?= htmlspecialchars($product['gender']) ?> — 
            <?= htmlspecialchars($product['category_name']) ?>
        </p>

        <h1><?= htmlspecialchars($product['name']) ?></h1>

        <p class="product-price">৳<?= number_format($product['price'], 2) ?></p>

        <!-- Stock label -->
        <?php if ($stock === 0): ?>
            <span class="stock-badge out">Out of Stock</span>
        <?php elseif ($stock < 5): ?>
            <span class="stock-badge low">Only <?= $stock ?> left!</span>
        <?php else: ?>
            <span class="stock-badge">In Stock</span>
        <?php endif; ?>

        <!-- Description -->
        <?php if (!empty($product['description'])): ?>
        <div class="product-section">
            <h4>Description</h4>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Size Chart -->
        <?php if (!empty($product['size_chart'])): ?>
        <div class="product-section">
            <h4>Size Chart</h4>
            <p><?= nl2br(htmlspecialchars($product['size_chart'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Add to Cart (only for logged-in customers) -->
        <?php if ($stock > 0 && $isLoggedIn && $role === 'customer'): ?>
        <div class="add-to-cart">
            <div class="qty-control">
                <button type="button" onclick="changeQty(-1)">−</button>
                <input type="number" id="quantity" value="1" min="1" max="<?= $stock ?>">
                <button type="button" onclick="changeQty(1)">+</button>
            </div>
            <button class="btn-primary" id="addToCartBtn"
                    data-product-id="<?= (int)$product['id'] ?>"
                    data-stock="<?= $stock ?>">
                ADD TO CART
            </button>
        </div>
        <p id="cartMessage"></p>

        <?php elseif ($stock > 0 && !$isLoggedIn): ?>
        <p class="login-prompt">
            <a href="login.php">Login</a> to add items to your cart.
        </p>

        <?php elseif ($stock === 0): ?>
        <button class="btn-primary" disabled>OUT OF STOCK</button>
        <?php endif; ?>

    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../public/js/cart.js"></script>
<script>
    // Simple quantity +/- buttons
    function changeQty(change) {
        const input = document.getElementById('quantity');
        const max   = parseInt(input.max);
        let val     = parseInt(input.value) + change;
        if (val < 1)   val = 1;
        if (val > max) val = max;
        input.value = val;
    }
</script>
</body>
</html>