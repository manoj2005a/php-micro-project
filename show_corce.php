<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
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

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table td {
            background-color: #fff;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Course Management</h2>
    <table>
        <thead>
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Instructor</th>
            <th>Duration</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require("connection.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_course'])) {
            if(isset($_POST['id'])){
                $course_id = $_POST['id'];

                $sql = "DELETE FROM courses WHERE id = '$course_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Course deleted successfully');</script>";
                } else {
                    echo "<script>alert('Error deleting course: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Course ID not provided');</script>";
            }
        }

        $sql = "SELECT courses.*, teachers.teacher_name 
                FROM courses 
                LEFT JOIN teachers ON courses.instructor_id = teachers.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['course_name'] . "</td>";
                echo "<td>" . $row['teacher_name'] . "</td>";
                echo "<td>" . $row['duration'] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                if(isset($row['id'])){
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_course' onclick=\"return confirm('Are you sure you want to delete this course?');\">Delete</button>";
                } else {
                    echo "Course ID not provided";
                }
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No courses found</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
    <a href="add_course_form.php">Add New Course</a>
</div>
</body>
</html>
