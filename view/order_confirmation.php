<?php
include '../control/confirmation_process.php';
?>
<html>
<head>
    <title>Order Confirmed - StyleNest</title>
    <link rel="stylesheet" type="text/css" href="../public/css/mystyle.css" />
</head>
<body>
<div class="navbar">
    <a href="../view/Home.php" class="logo">StyleNest</a>
    <div class="nav-links">
        <a href="../view/cart.php">My Bag</a>
        <a href="../view/history.php">Orders</a>
        <a href="../view/profile.php">Profile</a>
    </div>
</div>

<div class="page-container">

    <?php if($order): ?>

    <div class="order-confirmation-container">

        <div class="confirm-icon">
            <span>&#10003;</span>
        </div>

        <h1 class="page-title mb-10">Order Confirmed!</h1>
        <p class="subtitle-text">Your order has been placed successfully.</p>

        
        <div class="card">
            <div class="order-info-grid">
                <div>
                    <div class="info-label">Order ID</div>
                    <div class="info-value">#<?php echo (int)$order["id"]; ?></div>
                </div>
                <div>
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span id="order_status" class="badge badge-pending"><?php echo ucfirst($order["status"]); ?></span>
                    </div>
                </div>
                <div>
                    <div class="info-label">Order Date</div>
                    <div class="info-value"><?php echo $order["order_date"]; ?></div>
                </div>
                <div>
                    <div class="info-label">Total Amount</div>
                    <div class="info-value price-orange">Tk <?php echo number_format($order["total_amount"], 2); ?></div>
                </div>
            </div>
        </div>

        
        <div class="section-header">
            <span class="step-number">1</span> ITEMS ORDERED
        </div>
        <div class="card-no-pad">
            <div class="card-body">
                <?php foreach($orderItems as $item): ?>
                <div class="order-product">
                    <img src="../public/uploads/<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="order-product-info">
                        <h4><?php echo htmlspecialchars($item["name"]); ?></h4>
                        <p class="meta">Quantity: <?php echo (int)$item["quantity"]; ?></p>
                        <p class="meta">Unit Price: Tk <?php echo number_format($item["unit_price"], 2); ?></p>
                    </div>
                    <span class="subtotal">Tk <?php echo number_format($item["unit_price"] * $item["quantity"], 2); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

            
        <?php if($payment): ?>
        <div class="section-header">
            <span class="step-number">2</span> PAYMENT INFO
        </div>
        <div class="card">
            <div class="order-info-grid">
                <div>
                    <div class="info-label">Method</div>
                    <div class="info-value"><?php echo htmlspecialchars($payment["payment_method"]); ?></div>
                </div>
                <div>
                    <div class="info-label">Transaction ID</div>
                    <div class="info-value"><?php echo htmlspecialchars($payment["transaction_id"]); ?></div>
                </div>
                <div>
                    <div class="info-label">Amount Paid</div>
                    <div class="info-value price-orange">Tk <?php echo number_format($payment["amount"], 2); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card text-center">
            <p id="status_result" class="status-result-msg"></p>
            <button onclick="checkOrderStatus(<?php echo (int)$order['id']; ?>)" class="btn btn-secondary btn-sm">REFRESH STATUS</button>
        </div>

        
        <div class="btn-group-center">
            <a href="../view/history.php" class="btn btn-secondary">VIEW PURCHASE HISTORY</a>
            <a href="../view/Home.php" class="btn btn-primary">CONTINUE SHOPPING</a>
        </div>

    </div>

    <?php else: ?>
    <div class="card empty-state">
        <p>Order not found.</p>
        <a href="../view/Home.php" class="btn btn-primary">GO SHOPPING</a>
    </div>
    <?php endif; ?>

</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
