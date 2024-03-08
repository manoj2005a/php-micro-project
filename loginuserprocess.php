<?php
session_start(); // Start session to manage user login state

// Database connection
require("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password verified, store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to dashboard or any other page after successful login
            header("Location: index.php");
            exit();
        } else {
            // Invalid password, display error message
            $error_message = "Invalid password";
        }
    } else {
        // User not found, display error message
        $error_message = "User not found";
    }
}

// Close database connection
$conn->close();
?>