<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST["username"]);
    $new_password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    
    // Validate input
    if (empty($new_username) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Update user information in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $new_username, $hashed_password, $user_id);
            
            if ($stmt->execute()) {
                $success = "Account information updated successfully!";
            } else {
                $error = "Error updating account: " . $stmt->error;
            }
            
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Account</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <div class="container">
        <h2>Update Account Information</h2>
        
        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        if (isset($success)) {
            echo "<p class='success'>$success</p>";
        }
        ?>
        
        <form action="account.php" method="POST">
            <label for="username">New Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit">Update Account</button>
        </form>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
