<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #333;
        }

        p {
            color: #666;
        }

        .course-banner {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .course-info {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }
        .take-course-button {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
}

.take-course-button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
<?php include "header.php"; ?>
    <div class="container">
        <h2>Course Details</h2>
        <?php
        require("connection.php");

        // Check if course ID is provided in the URL
        if (isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];

            // Fetch course details from the database
            $sql = "SELECT * FROM courses WHERE id = '$course_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $course_name = $row['course_name'];
                $instructor_id = $row['instructor_id'];
                $duration = $row['duration'];
                $description = $row['description'];
                $banner_path = $row['banner'];
                
                // Fetch instructor's name from the database
                $instructor_query = "SELECT teacher_name FROM teachers WHERE id = '$instructor_id'";
                $instructor_result = $conn->query($instructor_query);
                if ($instructor_result->num_rows > 0) {
                    $instructor_row = $instructor_result->fetch_assoc();
                    $instructor_name = $instructor_row['teacher_name'];
                } else {
                    $instructor_name = "Unknown";
                }
                ?>
                <img src="<?php echo $banner_path; ?>" alt="<?php echo $course_name; ?>" class="course-banner">
                <div class="course-info">
                    <h3><?php echo $course_name; ?></h3>
                    <p class="label">Instructor:</p>
                    <p><?php echo $instructor_name; ?></p> 
                    <p class="label">Duration:</p>
                    <p><?php echo $duration; ?></p>
                    <p class="label">Description:</p>
                    <p><?php echo $description; ?></p>
                    <a href="enroll_course.php?course_id=<?php echo $course_id; ?>" class="take-course-button">Take Course</a>
                </div>
                <?php
            } else {
                echo "<p>Course not found</p>";
            }
        } else {
            echo "<p>Course ID not provided</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
