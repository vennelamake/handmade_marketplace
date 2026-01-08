<?php 
session_start(); 
include '../db.php';

// Check if vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    header("Location: vendor_login.php");
    exit();
}

// Fetch vendor name - adjust based on your database structure
$vendor_id = $_SESSION['vendor_id'];
$vendor_name = $con->query("SELECT name FROM vendors WHERE id = $vendor_id")->fetch_assoc()['name'];

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendor_logout.php");
    exit();
}

// Fetch vendor-specific stats
$total_products = $con->query("SELECT COUNT(*) AS total FROM products WHERE vendor_id = $vendor_id")->fetch_assoc()['total'];
$total_orders = $con->query("SELECT COUNT(*) AS total FROM orders WHERE product_id IN (SELECT product_id FROM products WHERE vendor_id = $vendor_id)")->fetch_assoc()['total'];
$total_sales_result = $con->query("SELECT SUM(total_amount) AS total FROM orders WHERE product_id IN (SELECT product_id FROM products WHERE vendor_id = $vendor_id)");
$total_sales_row = $total_sales_result->fetch_assoc();
$total_sales = $total_sales_row['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    /* General Page Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

header {
    background-color: #4CAF50;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-container h1 {
    margin: 0;
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logout-btn {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.logout-btn:hover {
    background-color: #d32f2f;
}

/* Navigation Styles */
nav {
    background-color: #333;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin: 0;
}

nav ul li a {
    color: white;
    padding: 14px 20px;
    display: block;
    text-decoration: none;
}

nav ul li a:hover {
    background-color: #575757;
}

/* Container Styles */
.container {
    padding: 20px;
    max-width: 1000px;
    margin: auto;
}

h2 {
    text-align: center;
    color: #333;
}

/* Dashboard Stats */
.dashboard-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.stat-box {
    background-color: #fff;
    padding: 20px;
    width: 250px;
    margin: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    border-radius: 8px;
}

.stat-box h3 {
    margin-bottom: 10px;
    color: #4CAF50;
}

.stat-box p {
    font-size: 1.5em;
    margin: 0;
}

/* Table Styles */
.table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.table th, .table td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.table th {
    background-color: #4CAF50;
    color: white;
}

.table tr:hover {
    background-color: #f1f1f1;
}
</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="./vendor.css"> <!-- Use a separate CSS if desired -->
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Vendor Dashboard</h1>
            <div class="admin-info">
                <span>Welcome, <?php echo htmlspecialchars($vendor_name); ?></span>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="ManageProduct.php">Manage Products</a></li>
            <li><a href="VendorManageOrders.php">View Orders</a></li>
            <li><a href="ManagePayment.php">View Payments</a></li>
            <!-- Add more vendor-specific links if needed -->
        </ul>
    </nav>

    <div class="container">
        <h2>Dashboard Overview</h2>
        <div class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Products</h3>
                <p><?php echo $total_products; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Sales</h3>
                <p>₹ <?php echo number_format($total_sales, 2); ?></p>
            </div>
        </div>

        <h2>Recent Orders</h2>
        <table class="table">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            <?php
            $recent_orders = $con->query("
                SELECT o.order_id, u.username, o.order_date, o.status 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                WHERE o.product_id IN (SELECT product_id FROM products WHERE vendor_id = $vendor_id)
                ORDER BY o.order_date DESC
                LIMIT 5
            ");
            while ($order = $recent_orders->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
