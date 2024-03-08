<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add Course</h2>
        <div class="banner">
            <?php
            require("connection.php");
            // Check if error message is passed through URL parameters
            if (isset($_GET['message_type']) && isset($_GET['message_content']) && $_GET['message_type'] === 'error') {
                $error_msg = $_GET['message_content'];
                echo "<div class='error'>$error_msg</div>";
            }
                
            // Check if success message is passed through URL parameters
            if (isset($_GET['message_type']) && isset($_GET['message_content']) && $_GET['message_type'] === 'success') {
                $success_msg = $_GET['message_content'];
                echo "<div class='success'>$success_msg</div>";
            }
            ?>
        </div>
        <form action="add_course.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course-name">Course Name:</label>
                <input type="text" id="course-name" name="course-name" required>
            </div>
            <div class="form-group">
                <label for="instructor">Instructor:</label>
                <select id="instructor" name="instructor" required>
                    <option value="">Select Instructor</option>
                    <?php
                    require("connection.php");
                    // Database connection
                  

                    // Fetch instructors from database
                    $sql = "SELECT `id`, `teacher_name` FROM `teachers`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['teacher_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No instructors found</option>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="text" id="duration" name="duration" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            </div>
            <div class="form-group">
                <label for="banner">Banner Image:</label>
                <input type="file" id="banner" name="banner" accept="image/*" required>
            </div>
            <button type="submit">Add Course</button>
        </form>
    </div>
</body>
</html>
