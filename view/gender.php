<?php
require_once '../model/config.php';
require_once '../model/ProductModel.php';

$model = new ProductModel($conn);

$gender = $_GET['gender'] ?? '';

$products = $model->searchProducts('', '', $gender);
?>

<h2><?= htmlspecialchars($gender) ?> Products</h2>

<?php foreach ($products as $p): ?>
    <div>
        <a href="product_page.php?id=<?= $p['id'] ?>">
            <?= $p['name'] ?>
        </a>
    </div>
<?php endforeach; ?>