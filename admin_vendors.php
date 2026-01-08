<?php
session_start();
include 'db.php';

// Check if admin is logged in - adjust this as per your auth system
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Handle approve/reject actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['vendor_id'], $_POST['action'])) {
        $vendor_id = intval($_POST['vendor_id']);
        $action = $_POST['action'];

        if ($action === 'approve' || $action === 'reject') {
            $stmt = $con->prepare("UPDATE vendors SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $action, $vendor_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect to avoid form resubmission
    header('Location: admin_vendors.php');
    exit;
}

// Fetch all vendors (or only pending if you prefer)
$result = $con->query("SELECT * FROM vendors ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Vendor Approval</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 900px; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .status-pending { color: orange; font-weight: bold; }
        .status-approved { color: green; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
        form { display: inline; }
        button { margin-right: 5px; padding: 5px 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Vendor Approval Panel</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Business Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($vendor = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vendor['id']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['name']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['email']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['business_name']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['phone']); ?></td>
                    <td><?php echo htmlspecialchars($vendor['address']); ?></td>
                    <td class="status-<?php echo htmlspecialchars($vendor['status']); ?>">
                        <?php echo ucfirst(htmlspecialchars($vendor['status'])); ?>
                    </td>
                    <td>
                        <?php if ($vendor['status'] === 'pending'): ?>
                            <form method="POST" action="admin_vendors.php" style="display:inline;">
                                <input type="hidden" name="vendor_id" value="<?php echo $vendor['id']; ?>" />
                                <input type="hidden" name="action" value="approve" />
                                <button type="submit">Approve</button>
                            </form>
                            <form method="POST" action="admin_vendors.php" style="display:inline;">
                                <input type="hidden" name="vendor_id" value="<?php echo $vendor['id']; ?>" />
                                <input type="hidden" name="action" value="reject" />
                                <button type="submit">Reject</button>
                            </form>
                        <?php else: ?>
                            <!-- No actions if already approved/rejected -->
                            <em>N/A</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center;">No vendors found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
