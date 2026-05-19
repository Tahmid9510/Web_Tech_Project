<?php
require_once '../model/config.php';
require_once '../model/ProductModel.php';

$model = new ProductModel($conn);
$products = $model->searchProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleNest Home</title>

    <link rel="stylesheet" href="../public/css/nav_footer.css">
    <link rel="stylesheet" href="../public/css/task3.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div style="padding:40px; max-width:1200px; margin:auto;">

    <h1 style="margin-bottom:20px;">Shop Products</h1>


    <div style="display:flex; gap:15px; margin-bottom:30px; flex-wrap:wrap;">

        <input type="text"
               id="searchInput"
               placeholder="Search products..."
               style="padding:12px; width:250px;">

        <select id="categoryFilter" style="padding:12px;">
            <option value="">All Categories</option>
        </select>

        <select id="genderFilter" style="padding:12px;">
            <option value="">All Gender</option>
            <option value="Men">Men</option>
            <option value="Women">Women</option>
        </select>

    </div>

    <div id="productGrid"
         style="display:grid;
                grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
                gap:25px;">

        <?php foreach ($products as $p): ?>

            <a href="product_page.php?id=<?= $p['id'] ?>"
               style="text-decoration:none;color:inherit;">

                <div class="product-card"
                     style="border:1px solid #ddd;
                            padding:15px;
                            border-radius:8px;">

                         <img 
                         src="/Web_Tech_Project/public/uploads/products/<?= htmlspecialchars($p['image_path']) ?>" 
                         alt="Product Image"
                          style="width:100%; height:300px; object-fit:cover; border-radius:5px;">

                    <div style="margin-top:10px;">

                        <p style="color:#777; font-size:14px;">
                            <?= htmlspecialchars($p['gender']) ?>
                            —
                            <?= htmlspecialchars($p['category_name']) ?>
                        </p>

                        <h3>
                            <?= htmlspecialchars($p['name']) ?>
                        </h3>

                        <p>
                            ৳<?= number_format($p['price'], 2) ?>
                        </p>

                    </div>

                </div>

            </a>

        <?php endforeach; ?>

    </div>

</div>

<?php include 'footer.php'; ?>

<script src="../public/js/search.js"></script>

</body>
</html>