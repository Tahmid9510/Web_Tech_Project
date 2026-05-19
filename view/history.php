<?php
include '../control/history_process.php';
?>
<html>
<head>
    <title>Purchase History - StyleNest</title>
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

    <h1 class="page-title">Purchase History</h1>
    <p class="subtitle-text">Hello, <?php echo htmlspecialchars($_SESSION["username"]); ?>! Here are all your past orders.</p>

    <?php if(count($orders) > 0): ?>

    <div class="section-header">
        <span class="step-number"><?php echo count($orders); ?></span> YOUR ORDERS
    </div>
    <div class="card-no-pad">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <?php 
            foreach($orders as $order): 
                $orderId = (int)$order["id"];
                $orderDate = $order["order_date"];
                $totalAmount = number_format($order["total_amount"], 2);
                $status = $order["status"];
                $statusText = ucfirst($status);
                
                $statusClass = 'badge-pending';
                if($status == 'confirmed') {
                    $statusClass = 'badge-confirmed';
                } else if($status == 'rejected') {
                    $statusClass = 'badge-rejected';
                }
            ?>
            <tr>
                <td><strong>#<?php echo $orderId; ?></strong></td>
                <td><?php echo $orderDate; ?></td>
                <td>Tk <?php echo $totalAmount; ?></td>
                <td>
                    <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                </td>
                <td>
                    <a href="../view/order_detail.php?order_id=<?php echo $orderId; ?>" class="btn btn-primary btn-sm">VIEW</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php else: ?>
    <div class="card empty-state">
        <p>You have no orders yet.</p>
        <a href="../view/Home.php" class="btn btn-primary">START SHOPPING</a>
    </div>
    <?php endif; ?>

    <div class="btn-group mt-20">
        <a href="../view/profile.php" class="btn btn-secondary">BACK TO PROFILE</a>
        <a href="../view/cart.php" class="btn btn-primary">CONTINUE SHOPPING</a>
    </div>

</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
