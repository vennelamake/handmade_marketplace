<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $con->prepare("SELECT id, name, email, password, status FROM vendors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $vendor = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $vendor['password'])) {
                // Check vendor status
                if ($vendor['status'] === 'approved') {
                    // Login success - store vendor info in session
                    $_SESSION['vendor_id'] = $vendor['id'];
                    $_SESSION['vendor_name'] = $vendor['name'];
                    $_SESSION['vendor_email'] = $vendor['email'];

                    // Redirect to vendor dashboard or homepage
                   header('Location: vendor/index.php');   // Correct vendor dashboard

                    exit;
                } elseif ($vendor['status'] === 'pending') {
                    $error = "Your account is pending approval by admin.";
                } else {
                    $error = "Your account has been rejected.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Vendor Login</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 400px; margin: auto; }
        form { display: flex; flex-direction: column; }
        input { margin: 10px 0; padding: 8px; }
        button { padding: 10px; background-color: #2874f0; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Vendor Login</h2>

<form method="POST" action="vendor_login.php">
    <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>" />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
</form>

<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<p style="text-align:center; margin-top: 20px;">
    Not registered? <a href="vendor_register.php">Register here</a>
</p>

</body>
</html>
