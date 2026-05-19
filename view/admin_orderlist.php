<?php
    include "../control/admin_orderlist_process.php"
?>


<html>
<head>
    <title>Order List</title>
    <link rel="stylesheet" href="../public/css/admin_orderlist.css">
</head>
<body>
    <!-- navber -->
    <?php include "admin_navbar.php" ?> 
    <!-- navber -->

    <main>
        <h2>Orders List</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($orders as $order) { ?>
                <tr id="row-<?= $order['id'] ?>">
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['name'] ?></td>
                    <td>$<?= $order['total_amount'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td id="status-<?= $order['id'] ?>">
                        <?= strtolower($order['status']) ?>
                    </td>     
                    <td>
                        <button class="confirmBtn" onclick="updateStatus(<?= $order['id'] ?>, 'confirmed')">Confirm</button>
                        <button class="rejectBtn" onclick="updateStatus(<?= $order['id'] ?>, 'rejected')">Reject</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>


    <!-- footer -->
    <?php include "admin_footer.php" ?>
    <!-- footer -->
    <script src="../public/js/script.js"></script>
</body>
</html>