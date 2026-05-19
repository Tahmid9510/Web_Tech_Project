<?php
    include "../control/admin_history_process.php";
?>


<html>
<head>
    <link rel="stylesheet" href="../public/css/admin_history.css">
</head>
<body>
    <!-- navbar -->
    <?php include "admin_navbar.php" ?>
    <!-- navbar -->
    
    <main>

        <h2>Sales History</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Order Date</th>
            </tr>
            <?php foreach($sales as $sale) { ?>
                <tr>
                    <td><?= $sale['id'] ?></td>
                    <td><?= $sale['name'] ?></td>
                    <td>$<?= $sale['total_amount'] ?></td>
                    <td><?= $sale['order_date'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </main>
    
    
    <!-- footer -->
    <?php include "admin_footer.php" ?>
    <!-- footer -->
</body>
</html>