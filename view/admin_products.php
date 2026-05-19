<?php
    include "../control/admin_products_process.php"
?>


<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="../public/css/admin_products.css">
</head>
<body>
    <!-- Navber -->
    <?php include "admin_navbar.php" ?>
    <!-- Navber -->

    <main>
        <div class="header">
            <div class="product-cnt">
                <h2>Total Products</h2>
                <p><?php echo $totalProducts; ?></p>
            </div>
            <div>
                <a class="add-btn" href="http://localhost/Web_Tech_Project/view/admin_addproducts.php">+ Add Product</a>
                <?php if($success != "") { ?>
                    <p class="success"><?php echo $success; ?></p>
                <?php } ?>
                <?php if($error != "") { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>

                <h2>Product List</h2>
            </div>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td>
                    <img src="<?= $product['image_path'] ?>">
                </td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><?= htmlspecialchars($product['stock']) ?></td>
                <td><?= htmlspecialchars($product['gender']) ?></td>
                <td>
                    <div class="action_btn">
                        <a class="edit-btn" href="admin_editproduct.php?id=<?= $product['id'] ?>">Edit</a>
                        <form method="POST">
                            <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                            <button class="delete-btn" onclick="return confirm('Delete this product?')"> Delete </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </main>


    <!-- Footer -->
    <?php include "admin_footer.php" ?>
    <!-- Footer -->
</body>
</html>