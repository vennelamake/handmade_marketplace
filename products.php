<?php
include 'db.php';

// Fetch all products
$result = $con->query("SELECT * FROM product");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Products</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add a CSS file -->
</head>
<body>
    <h1>Available Products</h1>
    <div class="products">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" width="200">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p>Price: ₹ <?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <!-- Optional: Add "Add to Cart" button if you implement a cart system -->
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
<?php $con->close(); ?>
