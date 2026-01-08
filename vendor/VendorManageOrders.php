<?php
session_start();
include '../db.php';

// Check if the vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    header("Location: vendor_login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendor_login.php");
    exit();
}

$vendor_id = $_SESSION['vendor_id'];
$vendor_name = $con->query("SELECT business_name FROM vendors WHERE id = $vendor_id")->fetch_assoc()['business_name'] ?? 'Vendor';

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $check_order = $con->query("SELECT o.order_id FROM orders o 
                                JOIN products p ON o.product_id = p.product_id 
                                WHERE o.order_id = $order_id AND p.vendor_id = $vendor_id");
    if ($check_order->num_rows > 0) {
        $con->query("UPDATE orders SET status = '$new_status' WHERE order_id = $order_id");
    } else {
        echo "<div style='color:red;'>Unauthorized action.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Manage Orders</title>
    <style>
        /* Reset and basics */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #4CAF50;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav ul {
            list-style-type: none;
            margin: 0; padding: 0;
        }
        nav ul li {
            float: left;
        }
        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav ul li a.active, nav ul li a:hover {
            background-color: #4CAF50;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button.logout-btn {
            background-color: #f44336;
            padding: 8px 16px;
        }
        select {
            padding: 5px;
            border-radius: 4px;
        }
        .vendor-info span {
            margin-right: 15px;
        }
        @media (max-width: 600px) {
            nav ul li {
                float: none;
                width: 100%;
            }
            .table th, .table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Vendor Manage Orders</h1>
        </div>
        <div class="vendor-info">
            <span>Welcome, <?php echo htmlspecialchars($vendor_name); ?></span>
            <form method="POST" style="display: inline;">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="ManageProduct.php">Manage Products</a></li>
            <li><a href="VendorManageOrders.php" class="active">Manage Orders</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Your Product Orders</h2>
        <table class="table">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Product</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $orders = $con->query("SELECT o.*, u.username, p.name as product_name 
                                   FROM orders o 
                                   JOIN users u ON o.user_id = u.user_id 
                                   JOIN products p ON o.product_id = p.product_id 
                                   WHERE p.vendor_id = $vendor_id 
                                   ORDER BY o.order_date DESC");
            while ($order = $orders->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                <td><?php echo htmlspecialchars($order['username']); ?></td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        <select name="new_status">
                            <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="canceled" <?php echo ($order['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                        </select>
                        <button name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
