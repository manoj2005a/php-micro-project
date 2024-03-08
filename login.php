<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the email and password are provided
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Validate email and password (you can add more validation as needed)
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Perform authentication (replace this with your actual authentication logic)
        if ($email === 'admin@example.com' && $password === 'admin123') {
            // Redirect to the dashboard or homepage upon successful login
            header('Location:adpnale.php');
            exit();
        } else {
            // If authentication fails, redirect back to the login page with an error message
            header('Location: login.php?error=1');
            exit();
        }
    } else {
        // If email or password is missing, redirect back to the login page with an error message
        header('Location: login.php?error=2');
        exit();
    }
}
?>
