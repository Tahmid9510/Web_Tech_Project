<?php
include '../control/home_process.php';

function showProductImage($imagePath)
{
    if (!empty($imagePath)) {
        if (strpos($imagePath, 'public/') === 0) {
            return '../' . $imagePath;
        } else {
            return '../public/image/' . $imagePath;
        }
    }

    return '../public/image/product-placeholder.jpg';
}

function showPrice($price)
{
    $price = trim($price);

    if ($price === '') {
        return '';
    }

    if (strpos($price, '$') !== false || strpos($price, '৳') !== false) {
        return $price;
    }

    return '$' . $price;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Étoffe</title>
    <!-- <link rel="stylesheet" href="../public/css/layout.css"> -->
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="home-page">

    <section class="collection-section">

        <a href="gender.php?gender=Men" class="collection-card men-card">
            <div class="collection-overlay">
                <p>COLLECTION</p>
                <h1>Men</h1>
                <span>Shop now →</span>
            </div>
        </a>

        <a href="gender.php?gender=Women" class="collection-card women-card">
            <div class="collection-overlay">
                <p>COLLECTION</p>
                <h1>Women</h1>
                <span>Shop now →</span>
            </div>
        </a>

    </section>

    <section class="featured-section">

        <div class="section-heading">
            <p>JUST IN</p>
            <h2>Featured pieces</h2>
        </div>

        <div class="product-grid">

            <?php if (!empty($featuredProducts)) { ?>

                <?php foreach ($featuredProducts as $product) { ?>

                    <div class="product-card">
                        <a href="product_details.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <div class="product-image-box">
                                <img 
                                    src="<?php echo htmlspecialchars(showProductImage($product['image_path'])); ?>" 
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                >
                            </div>
                        </a>

                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars(showPrice($product['price'])); ?></p>
                    </div>

                <?php } ?>

            <?php } else { ?>

                <p class="no-products">No featured products available yet.</p>

            <?php } ?>

        </div>

    </section>

</main>

<?php include 'footer.php'; ?>
</body>
</html>