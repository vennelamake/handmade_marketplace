<?php
// Start session
session_start();
include 'db.php';  // Ensure db.php correctly connects to the database

// Predefined security questions
$security_questions = [
    "What was the name of your first pet?" => "What was the name of your first pet?",
    "In which city were you born?" => "In which city were you born?",
    "What is your mother's maiden name?" => "What is your mother's maiden name?",
    "What was your favorite teacher's name?" => "What was your favorite teacher's name?",
    "What was the name of your first school?" => "What was the name of your first school?"
];

$error_message = ''; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']);
    $ph_no = isset($_POST['ph_no']) ? trim($_POST['ph_no']) : '';  // Safe check
// or in PHP 7+
$ph_no = trim($_POST['ph_no'] ?? '');
 // ✅ Added extraction for phone number
    $security_question = trim($_POST['security_question']);
    $security_answer = trim($_POST['security_answer']);

    $errors = [];
    // Validations
    if (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $username)) {
        $errors[] = "Username should be alphanumeric and 3-20 characters long.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters, with uppercase, lowercase, number, and special character.";
    }
    if (empty($address)) {
        $errors[] = "Address cannot be empty.";
    }
    if (!preg_match("/^\d{10}$/", $ph_no)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }
    if (!array_key_exists($security_question, $security_questions)) {
        $errors[] = "Invalid security question selected.";
    }
    if (empty($security_answer)) {
        $errors[] = "Security answer cannot be empty.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $hashed_security_answer = password_hash($security_answer, PASSWORD_DEFAULT);

        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username or email is already taken.";
        } else {
            $stmt = $con->prepare("INSERT INTO users (username, email, password, Address, ph_no, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $username, $email, $hashed_password, $address, $ph_no, $security_question, $hashed_security_answer);
            if ($stmt->execute()) {
                header("Location: Login.php");
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        // Collect validation errors into a single message
        $error_message = implode("<br>", $errors);
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="./Styles/register.css">
    <script>
        function validateForm() {
            let username = document.getElementById("username").value;
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let address = document.getElementById("address").value;
            let ph_no = document.getElementById("ph_no").value;
            let security_question = document.getElementById("security_question").value;
            let security_answer = document.getElementById("security_answer").value;
            let errors = [];

            if (!/^[a-zA-Z0-9]{3,20}$/.test(username)) {
                errors.push("Username should be alphanumeric and 3-20 characters long.");
            }
            if (!/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(email)) {
                errors.push("Invalid email format.");
            }
            if (!/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password)) {
                errors.push("Password must be at least 8 characters, with uppercase, lowercase, number, and special character.");
            }
            if (!/^\d{10}$/.test(ph_no)) {
                errors.push("Phone number must be exactly 10 digits.");
            }
            if (address.trim() === "") {
                errors.push("Address cannot be empty.");
            }
            if (security_question === "") {
                errors.push("Please select a security question.");
            }
            if (security_answer.trim() === "") {
                errors.push("Security answer cannot be empty.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="login-container">
    <form action="register.php" method="POST" onsubmit="return validateForm()">
        <h1>Register Here</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color:red;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="form-grid">
            <div class="form-group">
                <label>User Name:</label>
                <input type="text" id="username" name="username" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <div class="form-group">
                <label>Phone Number:</label> <!-- ✅ Added this field -->
                <input type="text" id="ph_no" name="ph_no" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label>Security Question:</label>
                <select id="security_question" name="security_question" required>
                    <option value="">Select a Security Question</option>
                    <?php foreach($security_questions as $question): ?>
                        <option value="<?php echo htmlspecialchars($question); ?>"><?php echo htmlspecialchars($question); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Security Answer:</label>
                <input type="text" id="security_answer" name="security_answer" placeholder="Enter your security answer" required>
            </div>
            <input type="submit" value="Register">
            <div class="register-link">
                <span>Already Registered?</span>
                <a href="Login.php">Login Now</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
