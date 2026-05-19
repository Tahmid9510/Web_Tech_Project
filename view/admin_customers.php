<?php
    include "../control/admin_customers_process.php";
?>

<html>
<head>
    <title>Customers</title>
    <link rel="stylesheet" href="../public/css/admin_customers.css">
</head>
<body>
    <!-- Navber -->
    <!-- Navber -->


    <h2>Customers List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Profile Picture</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php foreach ($customers as $customer) { ?>
            <tr>
                <td><?= $customer['id'] ?></td>
                <td><img src="<?= $customer['profile_picture'] ?>"></td>
                <td><?= $customer['name'] ?></td>
                <td><?= $customer['email'] ?></td>
                <td><?= $customer['phone'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?= $customer['id'] ?>">
                        <button class="deleteBtn" onclick="return confirm('Delete this customer?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Footer -->
    <!-- Footer -->
</body>
</html>