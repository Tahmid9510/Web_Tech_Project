<?php
    include'../control/admin_products_process.php';
    
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/admin_products.css">
</head>
<body>
    <!-- Navber -->

    <!-- Navber -->

    <!-- Create Product -->

    <div class="container">
        <div class="header">
            <h1>Create New Product</h1>
        </div>
        <?php if($success != "") { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <?php if($error != "") { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="input-group">
                    <label>Product Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-group">
                    <label>Price</label>
                    <input type="text" step="0.01" name="price" required>
                </div>
            </div>

            <!-- category -->
            <div class="row">
                <div class="input-group">
                    <label>Category</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                            $conn = $myDB->createConn();
                            $categoryQuery = "SELECT * FROM categories";
                            $categoryResult = $conn->query($categoryQuery);
                            if($categoryResult->num_rows > 0){
                            while($category = $categoryResult->fetch_assoc()){
                        ?>
                            <option value="<?php echo $category['name']; ?>">
                                <?php echo $category['name']; ?>
                            </option>
                        <?php
                                }
                            }
                            $myDB->closeConn($conn);
                        ?>
                    </select>
                </div>


                <div class="input-group">
                    <label>Stock Quantity</label>
                    <input type="text" name="stock" required>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select</option>
                        <option value="Men">Men</option>
                        <option value="Women">Women</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Product Image</label>
                    <input type="file" name="image" required>
                </div>

            </div>
            <div class="input-group">
                <label>Size Chart</label>
                <input type="text" name="size_chart" required>
            </div>
            <div class="input-group">
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>
            <button class="addBtn" type="submit">Add Product</button>
        </form>

    </div>


    <!-- product List -->
    

    <!-- Footer -->
    <!-- Footer -->
</body>
</html>