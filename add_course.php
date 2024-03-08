<?php
require("connection.php");

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $course_name = $conn->real_escape_string($_POST['course-name']);
    $instructor_id = $conn->real_escape_string($_POST['instructor']);
    $duration = $conn->real_escape_string($_POST['duration']);

    // Handle file upload for banner
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["banner"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["banner"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["banner"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
            // File uploaded successfully, proceed with database insertion
            $banner_path = $target_file;

            // Check if the course already exists
            $existing_course_query = "SELECT * FROM courses WHERE course_name = '$course_name'";
            $existing_course_result = $conn->query($existing_course_query);
            if ($existing_course_result->num_rows > 0) {
                $message_type = "error";
                $message_content = "Error: Course already exists.";
            } else {
                // Insert data into courses table
                $sql = "INSERT INTO courses (course_name, instructor_id, duration, banner) VALUES ('$course_name', '$instructor_id', '$duration', '$banner_path')";

                if ($conn->query($sql) === TRUE) {
                    // Fetch instructor name
                    $instructor_name_query = "SELECT teacher_name FROM teachers WHERE id = '$instructor_id'";
                    $instructor_name_result = $conn->query($instructor_name_query);
                    if ($instructor_name_result->num_rows > 0) {
                        $instructor_row = $instructor_name_result->fetch_assoc();
                        $instructor_name = $instructor_row['teacher_name'];
                    }

                    $message_type = "success";
                    $message_content = "Course added successfully! Instructor: $instructor_name";
                } else {
                    $message_type = "error";
                    $message_content = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            $message_type = "error";
            $message_content = "Error uploading file.";
        }
    } else {
        $message_type = "error";
        $message_content = "Invalid file format or file too large.";
    }

    // Redirect with message
    header("Location: add_course_form.php?message_type=$message_type&message_content=$message_content");
    exit();
}

// Close connection
$conn->close();
?>
