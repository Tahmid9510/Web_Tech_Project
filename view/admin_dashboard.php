<?php
    include'../control/admin_dashboard_process.php';
    $name = "Suzit Datta";
    $role = "Admin";
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/admin_dashboard.css">
</head>
<body>
    
    <!-- Navber -->
    <!-- Navber -->
    <div class="description">
        <h2>Welcome <?php echo $name;?></h2>
        <p>Role: <?php echo $role;?></p>
    </div>
    <div class="dashboard">
        <p>Dashboard</p>

        <div class="card-container">
            <div class="card">
                <h3>Total Products</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>

            <div class="card">
                <h3>Total Customers</h3>
                <p><?php echo $totalCustomers; ?></p>
            </div>

            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>

            <div class="card pending">
                <h3>Pending Orders</h3>
                <p><?php echo $pendingOrders; ?></p>
            </div>

        </div>

    </div>
</body>
</html>