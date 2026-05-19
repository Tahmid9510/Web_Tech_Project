<?php
include '../control/gender_process.php';

if (!isset($categories)) {
    $categories = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($gender); ?> Collection</title>
    <link rel="stylesheet" href="../public/css/gender.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="gender-page">

    <section class="gender-header">
        <p>COLLECTION</p>
        <h1><?php echo htmlspecialchars($gender); ?></h1>
    </section>

    <section class="category-buttons">
 
        <?php foreach ($categories as $category) { ?>

            <a 
                href="gender.php?gender=<?php echo htmlspecialchars($gender); ?>&category_id=<?php echo htmlspecialchars($category['id']); ?>" 
                class="category-btn <?php echo ($selectedCategoryId == $category['id']) ? 'active-category' : ''; ?>"
            >
                <?php echo htmlspecialchars(strtoupper($category["name"])); ?>
            </a>

        <?php } ?>

    </section>

    <section class="gender-products">

        <?php if (!empty($products)) { ?>

            <div class="product-grid">

                <?php foreach ($products as $product) { ?>

                    <div class="product-card">

                        <div class="product-image-box">
                            <img 
                                src="<?php echo htmlspecialchars(showProductImage($product['image_path'])); ?>" 
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                            >
                        </div>

                        <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
                        <p><?php echo "$".htmlspecialchars($product["price"]); ?></p>

                    </div>

                <?php } ?>

            </div>

        <?php } else { ?>

            <p class="no-products">No products found in this collection.</p>

        <?php } ?>

    </section>

</main>

<?php include 'footer.php'; ?>
</body>
</html>