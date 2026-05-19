<?php
session_start();
include '../model/mydb.php';

if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
}

$mydb = new MyDB();
$conn = $mydb->createConn();
$userResult = $mydb->getUser($_SESSION["username"], $conn);
$user_id = null;
if($userResult && $userResult->num_rows > 0){
    foreach($userResult as $row){
        $user_id = $row["id"];
    }
}


if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
    
    if ($check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $new_qty = $row['quantity'] + $quantity;
        $conn->query("UPDATE cart SET quantity = '$new_qty' WHERE id = '".$row['id']."'");
    } else {
        $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
    }
    header("Location: cart.php");
    exit();
}


if (isset($_POST['clear_cart'])) {
    $mydb->clearCart($user_id, $conn);
    header("Location: cart.php");
    exit();
}


$cartItems = [];
$totalAmount = 0;
$cartResult = $mydb->getCartByUser($user_id, $conn);
if($cartResult && $cartResult->num_rows > 0){
    foreach($cartResult as $row){
        $cartItems[] = $row;
        $totalAmount += $row["price"] * $row["quantity"];
    }
}


$productsResult = $conn->query("SELECT * FROM products");
$products = [];
if($productsResult && $productsResult->num_rows > 0){
    foreach($productsResult as $row){
        $products[] = $row;
    }
}
?>
<html>
<head>
    <title>My Bag - StyleNest</title>
    <link rel="stylesheet" type="text/css" href="../public/css/mystyle.css" />
</head>
<body>


<div class="navbar">
    <a href="../view/Home.php" class="logo">StyleNest</a>
    <div class="nav-links">
        <a href="../view/cart.php">My Bag</a>
        <a href="../view/history.php">Orders</a>
        <a href="../view/profile.php">Profile</a>
    </div>
</div>

<div class="page-container">

    
    <h1 class="page-title">My Bag (<?php echo count($cartItems); ?> Items)</h1>

    <?php if(count($cartItems) == 0 && count($products) == 0): ?>
        <div class="card empty-state">
            <p>Your bag is empty and no products are available.</p>
            <a href="../view/Home.php" class="btn btn-primary">CONTINUE SHOPPING</a>
        </div>
    <?php else: ?>

    <div class="cart-layout">

        
        <div class="cart-main">

            
            <div class="section-header">
                <span class="step-number">1</span> AVAILABLE PRODUCTS
            </div>
            <div class="card-no-pad">
                <div class="card-body">
                    <?php foreach($products as $p): ?>
                    <div class="cart-item">
                        <img src="../public/uploads/<?php echo $p['image_path']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="cart-item-img">
                        <div class="cart-item-details">
                            <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                            <span class="stock-label">In Stock</span>
                            <p class="price">Tk <?php echo number_format($p['price'], 2); ?></p>
                            <form method="post" class="cart-item-form">
                                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                <div class="qty-control">
                                    <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                                    <input type="number" name="quantity" value="1" min="1">
                                    <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                                &nbsp;&nbsp;
                                <input type="submit" name="add_to_cart" value="ADD TO BAG" class="btn btn-primary btn-sm">
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            
            <?php if(count($cartItems) > 0): ?>
            <div class="section-header">
                <span class="step-number">2</span> YOUR BAG
            </div>
            <div class="card-no-pad">
                <div class="card-body">
                    <?php foreach($cartItems as $item): ?>
                    <div class="cart-item">
                        <img src="../public/uploads/<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-img">
                        <div class="cart-item-details">
                            <h4><?php echo htmlspecialchars($item["name"]); ?></h4>
                            <span class="stock-label">In Stock</span>
                            <p class="price">Tk <?php echo number_format($item["price"], 2); ?></p>
                            <p class="cart-item-qty">Quantity: <?php echo (int)$item["quantity"]; ?></p>
                        </div>
                        <div class="subtotal subtotal-container">
                            <p class="subtotal-price">Tk <?php echo number_format($item["price"] * $item["quantity"], 2); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="btn-group">
                <form method="post">
                    <input type="submit" name="clear_cart" value="CLEAR BAG" class="btn btn-secondary">
                </form>
                <a href="../view/Home.php" class="btn btn-secondary">CONTINUE SHOPPING</a>
            </div>
            <?php endif; ?>

        </div>

        
        <?php if(count($cartItems) > 0): ?>
        <div class="cart-sidebar">
            <a href="checkout.php" class="btn btn-primary btn-block btn-checkout">CHECKOUT</a>

            <div class="section-header">
                <span class="step-number">✓</span> ORDER SUMMARY
            </div>
            <div class="card-no-pad">
                <div class="card-body">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Tk <?php echo number_format($totalAmount, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="price-orange">Tk <?php echo number_format($totalAmount, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <?php endif; ?>

</div>

<script src="../public/js/myscript.js"></script>
</body>
</html>
