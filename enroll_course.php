<?php
// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Course</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
}

p {
    margin-bottom: 15px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
        <h2>Enroll in Course</h2>
        <?php
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<p>You must be logged in to enroll in a course. Please <a href='login.php'>log in</a> or <a href='signup.php'>sign up</a>.</p>";
            exit();
        }

        // Check if the course ID is provided in the URL
        if (isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];

            // Check if the user is already enrolled in this course
            $user_id = $_SESSION['user_id'];
            $check_enrollment_query = "SELECT * FROM users WHERE id = '$user_id' AND corseid = '$course_id'";
            $check_enrollment_result = $conn->query($check_enrollment_query);
            if ($check_enrollment_result->num_rows > 0) {
                echo "<p>You are already enrolled in this course.</p>";
            } else {
                // Enroll the user in the course
                $enroll_query = "UPDATE users SET corseid = '$course_id' WHERE id = '$user_id'";
                if ($conn->query($enroll_query) === TRUE) {
                    echo "<p>Enrollment successful!</p>";
                } else {
                    echo "<p>Error enrolling in the course: " . $conn->error . "</p>";
                }
            }
        } else {
            echo "<p>Course ID not provided.</p>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
