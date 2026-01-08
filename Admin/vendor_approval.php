<?php
session_start();
include '../db.php';

// Check if the admin is logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: AdminLogin.php");
    exit();
}

// Fetch pending vendors
$result = $con->query("SELECT * FROM vendors WHERE status = 'pending'");

if (!$result) {
    die("Database query failed: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Approval</title>
    <link rel="stylesheet" href="./admin.css">
    <style>
        /* General Body Styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    padding: 40px;
    margin: 0;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

a {
    text-decoration: none;
    color: #007BFF;
}

a:hover {
    text-decoration: underline;
}

/* Table Styling */
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px 15px;
    text-align: left;
}

th {
    background-color: #007BFF;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

td a {
    color: #28a745;
    font-weight: 500;
}

td a:hover {
    color: #218838;
}

/* Back to Dashboard Link */
a[href="index.php"] {
    display: block;
    margin: 10px auto;
    width: fit-content;
    background-color: #007BFF;
    color: #fff;
    padding: 10px 15px;
    border-radius: 6px;
    transition: background-color 0.3s;
}

a[href="index.php"]:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>
    <h1>Vendor Approval</h1>
    <a href="index.php">← Back to Dashboard</a>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Business</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php while($vendor = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $vendor['id']; ?></td>
                    <td><?php echo htmlspecialchars($vendor['name']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['email']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['business_name']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['phone']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['address']); ?></td>
                    <td>
                        <a href="vendor_action.php?id=<?php echo $vendor['id']; ?>&action=approve">Approve</a> |
                        <a href="vendor_action.php?id=<?php echo $vendor['id']; ?>&action=reject">Reject</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending vendors to approve.</p>
    <?php endif; ?>
</body>
</html>

<?php $con->close(); ?>
