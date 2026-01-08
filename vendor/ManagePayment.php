<?php 
session_start(); 
include '../db.php'; 

if (!isset($_SESSION['vendor_id'])) {
    header("Location: vendor_login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendor_login.php");
    exit();
}

$admin_name = $con->query("SELECT username FROM admin WHERE admin_id = " . $_SESSION['admin_id'])->fetch_assoc()['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
    <link rel="stylesheet" href="./admin.css">
    <style>
        /* General Body Styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-color: #f4f6f9;
}

/* Header */
header {
    background-color: #007BFF;
    color: #fff;
    padding: 15px 30px;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-info {
    display: flex;
    align-items: center;
}

.logout-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 8px 15px;
    margin-left: 15px;
    cursor: pointer;
    border-radius: 4px;
}

.logout-btn:hover {
    background-color: #c82333;
}

/* Navigation Bar */
nav {
    background-color: #343a40;
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
    display: block;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
}

nav ul li a:hover,
nav ul li a.active {
    background-color: #495057;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 30px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.container h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: left;
}

.table th {
    background-color: #007BFF;
    color: #fff;
}

.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tr:hover {
    background-color: #f1f1f1;
}

.table td {
    color: #333;
}

.table td:nth-child(4) {
    color: #28a745; /* Green color for Amount column */
    font-weight: bold;
}

.table td:nth-child(7) {
    font-weight: bold;
}
</style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Manage Payments</h1>
            <div class="admin-info">
                <span>Welcome, <?php echo htmlspecialchars($admin_name); ?></span>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>
    
    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="ManageProduct.php">Manage Products</a></li>
            <li><a href="VendorManageOrders.php">Manage Orders</a></li>
            <li><a href="ManagePayement.php" class="active">Manage Payments</a></li>
            
        </ul>
    </nav>

    <div class="container">
        <h2>Payment Transactions</h2>
        <table class="table">
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Payment Type</th>
                <th>Payment Date</th>
                <th>Order Status</th>
            </tr>
            <?php
            $payments = $con->query("SELECT payments.*, orders.status, users.username 
                                    FROM payments 
                                    JOIN orders ON payments.order_id = orders.order_id 
                                    JOIN users ON orders.user_id = users.user_id 
                                    ORDER BY payment_date DESC");
            while ($payment = $payments->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                <td><?php echo htmlspecialchars($payment['order_id']); ?></td>
                <td><?php echo htmlspecialchars($payment['username']); ?></td>
                <td>₹<?php echo number_format($payment['amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($payment['payment_type']); ?></td>
                <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                <td><?php echo htmlspecialchars($payment['status']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>