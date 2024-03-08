<?php
// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Database connection
require("connection.php");

// Fetch user details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = $conn->query($user_query);

// Fetch enrolled courses
$course_query = "SELECT courses.id, courses.course_name, courses.instructor_id, courses.duration, courses.banner, courses.description, courses.created_at, teachers.teacher_name
                FROM courses
                INNER JOIN users ON FIND_IN_SET(courses.id, users.corseid)
                LEFT JOIN teachers ON courses.instructor_id = teachers.id
                WHERE users.id = '$user_id'";
$course_result = $conn->query($course_query);
?>
<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        
        
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    h3 {
        margin-top: 30px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
        border-bottom: 1px solid #ccc;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .profile-info p {
        margin: 5px 0;
    }

    .profile-info img {
        max-width: 150px;
        height: auto;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: block;
    }

    .course {
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        padding: 20px;
    }

    .course img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .course h4 {
        margin-top: 0;
    }


    </style>
</head>
<body>
    <h2>User Profile</h2>

    <?php if ($user_result->num_rows > 0) : ?>
        <?php $user = $user_result->fetch_assoc(); ?>
        <h3>User Details</h3>
        <p>Profile Image: <img src="<?php echo $user['profile_image']; ?>" alt="Profile Image"></p>

        <p>Name: <?php echo $user['name']; ?></p>
        <p>Birthdate: <?php echo $user['birthdate']; ?></p>
        <p>Address: <?php echo $user['address']; ?></p>
        <p>College: <?php echo $user['college']; ?></p>
        <p>Contact: <?php echo $user['contact']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
      
        <h3>Enrolled Courses</h3>
        <?php if ($course_result->num_rows > 0) : ?>
            <?php while ($course = $course_result->fetch_assoc()) : ?>
                <div class="course">
                    <img src="<?php echo $course['banner']; ?>" alt="<?php echo $course['course_name']; ?>" width="100">
                    <h4><?php echo $course['course_name']; ?></h4>
                    <p>Instructor: <?php echo $course['teacher_name']; ?></p>
                    <p>Duration: <?php echo $course['duration']; ?></p>
                    <p>Instructor ID: <?php echo $course['instructor_id']; ?></p>
                    <p>Created At: <?php echo $course['created_at']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No enrolled courses found.</p>
        <?php endif; ?>
    <?php else : ?>
        <p>User details not found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
