<?php
session_start();
include '../db.php'; // Include your database connection

if (!isset($_SESSION['vendor_id'])) {
    header("Location: vendor_login.php"); // Redirect to vendor login if not logged in
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendor_login.php");
    exit();
}

$vendor_name = $con->query("SELECT name FROM vendors WHERE id = " . $_SESSION['vendor_id'])->fetch_assoc()['name'];

// Fetch all categories
$categories = $con->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

// Fetch products for this vendor
$vendor_id = $_SESSION['vendor_id'];
$products = $con->query("SELECT p.*, c.name AS category_name 
                        FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.category_id 
                        WHERE p.vendor_id = $vendor_id 
                        ORDER BY c.name")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Vendor.css"> <!-- Use vendor-specific CSS if needed -->
    <title>Vendor Manage Products</title>
    <style>
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        .table th {
            background-color: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .action-buttons input[type="submit"] {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .action-buttons input[value="Update"] {
            background-color: #4CAF50;
            color: white;
        }
        
        .action-buttons input[value="Delete"] {
            background-color: #f44336;
            color: white;
        }
        /* Vendor.css */

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9fb;
    margin: 0;
    padding: 0;
    color: #333;
}

header {
    background-color: #34495e;
    color: white;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.vendor-info {
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 15px;
}

.vendor-info span {
    font-weight: 600;
}

.logout-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #c0392b;
}

nav {
    background-color: #2c3e50;
}

nav ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 10px 40px;
}

nav ul li {
    margin-right: 25px;
}

nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-weight: 600;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover,
nav ul li a.active {
    background-color: #34495e;
}

.container {
    max-width: 1100px;
    margin: 30px auto;
    background-color: white;
    padding: 25px 40px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

h2, h3 {
    color: #2c3e50;
    margin-bottom: 15px;
}

h3 {
    margin-top: 40px;
    border-bottom: 2px solid #3498db;
    padding-bottom: 6px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
}

.table th, .table td {
    padding: 14px 12px;
    border: 1px solid #ddd;
    vertical-align: middle;
}

.table th {
    background-color: #ecf0f1;
    font-weight: 700;
    color: #34495e;
    text-align: left;
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.error-image {
    color: #e74c3c;
    font-size: 0.9rem;
    font-style: italic;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.action-buttons form {
    margin: 0;
}

.action-buttons input[type="submit"] {
    padding: 8px 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: background-color 0.25s ease;
}

.action-buttons input[value="Update"] {
    background-color: #27ae60;
    color: white;
}

.action-buttons input[value="Update"]:hover {
    background-color: #1e8449;
}

.action-buttons input[value="Delete"] {
    background-color: #e74c3c;
    color: white;
}

.action-buttons input[value="Delete"]:hover {
    background-color: #c0392b;
}

.action-buttons input[type="submit"]:focus {
    outline: 2px solid #3498db;
}

.action-buttons > form:nth-child(1) input[type="submit"] {
    min-width: 140px;
    background-color: #2980b9;
    color: white;
}

.action-buttons > form:nth-child(1) input[type="submit"]:hover {
    background-color: #1c5980;
}

/* Responsive */
@media (max-width: 900px) {
    nav ul {
        flex-direction: column;
        padding: 10px 20px;
    }
    nav ul li {
        margin: 10px 0;
    }

    .container {
        padding: 20px;
        margin: 20px 15px;
    }

    .table th, .table td {
        padding: 10px 8px;
        font-size: 0.9rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
    }

    .action-buttons {
        flex-direction: column;
    }
}

    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Manage Your Products</h1>
            <div class="vendor-info">
                <span>Welcome, <?php echo htmlspecialchars($vendor_name); ?></span>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Vendor Dashboard</a></li>
            <li><a href="ManageProduct.php">Manage Products</a></li>
            <li><a href="VendorManageOrders.php">Manage Orders</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Your Product List</h2>

        <?php foreach ($categories as $category): ?>
            <h3><?php echo htmlspecialchars($category['name']); ?></h3>
            <table class="table">
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <?php if ($product['category_id'] == $category['category_id']): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td>₨ <?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td>
                                <?php
                                    $image_path = '../' . $product['Image'];
                                    if (!empty($image_path) && file_exists($image_path)):
                                ?>
                                    <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                                <?php else: ?>
                                    <div class="error-image">
                                        Image not found
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="action-buttons">
                                <form action="VendorUpdateProduct.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="submit" value="Update">
                                </form>
                                <form action="VendorDeleteProduct.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this product?');">
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>

        <h2>Actions</h2>
        <div class="action-buttons">
            <form action="VendorAddProduct.php" method="POST">
                <input type="submit" value="Add New Product">
            </form>
        </div>
    </div>

    <script>
        // Add error handling for images
        document.querySelectorAll('.product-image').forEach(img => {
            img.onerror = function() {
                this.onerror = null;
                this.src = 'placeholder.jpg'; // Use placeholder image
                this.alt = 'Image not found';
            };
        });
    </script>
</body>
</html>
