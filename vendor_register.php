<?php
session_start();
include 'db.php';  // Your DB connection

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs and sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $business_name = trim($_POST['business_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Basic validation
    if (!$name) $errors[] = "Name is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$password) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (!$business_name) $errors[] = "Business name is required.";
    if (!$phone) $errors[] = "Phone number is required.";
    if (!$address) $errors[] = "Address is required.";

    // If no errors, proceed
    if (empty($errors)) {
        // Check if email already exists
        $stmt = $con->prepare("SELECT id FROM vendors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into vendors table with status 'pending'
            $stmt = $con->prepare("INSERT INTO vendors (name, email, password, business_name, phone, address, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("ssssss", $name, $email, $hashed_password, $business_name, $phone, $address);

            if ($stmt->execute()) {
                $success = "Registration successful! Your account is pending approval.";
            } else {
                $errors[] = "Database error: Could not register vendor.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Vendor Registration</title>
    <style>
        /* Simple styling */
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin: 0 auto; }
        input, textarea { width: 100%; padding: 8px; margin: 8px 0; }
        .error { color: red; }
        .success { color: green; }
        button { padding: 10px 20px; }
        <style>
    /* Reset and base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        padding: 40px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    form {
        background: #fff;
        max-width: 500px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-weight: 500;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    input:focus, textarea:focus {
        border-color: #007BFF;
        outline: none;
    }

    button {
        width: 100%;
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error, .success {
        max-width: 500px;
        margin: 0 auto 20px;
        padding: 15px;
        border-radius: 6px;
        font-size: 14px;
    }

    .error {
        background-color: #ffe6e6;
        border: 1px solid #ff4d4d;
        color: #a94442;
    }

    .success {
        background-color: #e6ffe6;
        border: 1px solid #4CAF50;
        color: #2e7d32;
    }

    ul {
        padding-left: 20px;
    }

    @media (max-width: 600px) {
        form {
            padding: 20px;
        }
    }
</style>

    </style>
</head>
<body>

<h2>Vendor Registration</h2>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form action="vendor_register.php" method="POST">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" />

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required />

    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" required />

    <label for="business_name">Business Name</label>
    <input type="text" id="business_name" name="business_name" required value="<?php echo isset($business_name) ? htmlspecialchars($business_name) : ''; ?>" />

    <label for="phone">Phone Number</label>
    <input type="text" id="phone" name="phone" required value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" />

    <label for="address">Business Address</label>
    <textarea id="address" name="address" required><?php echo isset($address) ? htmlspecialchars($address) : ''; ?></textarea>

    <button type="submit">Register</button>
</form>

</body>
</html>
