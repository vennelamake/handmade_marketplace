<?php
session_start();
include '../db.php';

// Check if admin is logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: AdminLogin.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $vendor_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    } else {
        header("Location: vendor_approval.php");
        exit();
    }

    $stmt = $con->prepare("UPDATE vendors SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $vendor_id);

    if ($stmt->execute()) {
        $message = "Vendor status updated to '$status'.";
    } else {
        $message = "Error updating vendor: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
header("Location: vendor_approval.php");
exit();
?>
