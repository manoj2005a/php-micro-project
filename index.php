<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
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

        .course-container {
            position: relative;
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
        }

        .course-banner {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .course-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-top: 1px solid #ddd;
        }

        .course-title {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .view-details {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
            width: 70%;
        }

        .search-button {
            padding: 8px 16px;
            background-color: #007bff;
            border: none;
            border-radius: 0 5px 5px 0;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="container">
        <h2>All Courses</h2>

        
        <form class="search-form" method="GET" action="search_courses.php">
            <input class="search-input" type="text" name="query" placeholder="Search by course name or ID">
            <button class="search-button" type="submit">Search</button>
        </form>

        <?php
        require("connection.php");

        // Fetch courses from the database
        $sql = "SELECT * FROM courses";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $course_id = $row['id'];
                $course_name = $row['course_name'];
                $banner_path = $row['banner'];
                ?>
                <div class="course-container">
                    <div class="course-banner" style="background-image: url('<?php echo $banner_path; ?>');"></div>
                    <div class="course-info">
                        <h3 class="course-title"><?php echo $course_name; ?></h3>
                        <a href="course_details.php?course_id=<?php echo $course_id; ?>" class="view-details">View Details</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No courses available</p>";
        }

        $conn->close();
        ?>
        
    </div>
</body>
</html>
