<?php
include 'db.php';

// Fetch approved products
$result = $con->query("SELECT p.*, v.business_name FROM product p JOIN vendors v ON p.vendor_id = v.id WHERE v.status = 'approved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
</head>
<body>
    <h1>Products</h1>
    <ul>
        <?php while($product = $result->fetch_assoc()): ?>
        <li>
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p>Price: <?php echo $product['price']; ?></p>
            <p>Seller: <?php echo htmlspecialchars($product['business_name']); ?></p>
            <img src="uploads/<?php echo $product['image']; ?>" width="150">
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php $con->close(); ?>
