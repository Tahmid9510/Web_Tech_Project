<?php
    include "../control/admin_editproduct_process.php";
?>

<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/admin_editproduct.css">
</head>
<body>
    <!-- navber -->
    <?php include "admin_navbar.php" ?>
    <!-- navber -->

    <main>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <div class="row">
                <div class="input-group">
                    <label>Product Name</label>
                    <input type="text" name="name" value="<?= $product['name'] ?>" required>
                </div>
                <div class="input-group">
                    <label>Price</label>
                    <input type="text" name="price" value="<?= $product['price'] ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="input-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?=$category['name']?>"
                                <?= ($product['category_id'] == $category['name']) ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Stock</label>
                    <input type="text" name="stock" value="<?= $product['stock'] ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="input-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="Men" <?= $product['gender']=="Men"?"selected":"" ?>>Men</option>
                        <option value="Women" <?= $product['gender']=="Women"?"selected":"" ?>>Women</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Change Image</label>
                    <input type="file" name="image">
                </div>
            </div>
            <div class="input-group">
                <label>Size Chart</label>
                <input type="text" name="size_chart" value="<?= $product['size_chart'] ?>">
            </div>
            <div class="input-group">
                <label>Description</label>
                <textarea name="description"><?= $product['description'] ?></textarea>
            </div>
            <button class="addBtn" type="submit">Update Product</button>
        </form>
    </main>

    <!-- footer -->
    <?php include "admin_footer.php" ?>
    <!-- footer -->

</body>
</html>