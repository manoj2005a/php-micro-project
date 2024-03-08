<?php
require_once('connection.php');

function getCourseCount($conn) {
    $sql = "SELECT COUNT(*) AS course_count FROM courses";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['course_count'];
}


function getTeacherCount($conn) {
    $sql = "SELECT COUNT(*) AS teacher_count FROM teachers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['teacher_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        .stat {
            margin-bottom: 20px;
            text-align: center;
        }
        .round-button {
            display: inline-block;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            line-height: 100px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .round-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="admin-panel">
        <h2>Admin Panel</h2>
        <div class="stats">
            <div class="stat">
                <h3>Number of Courses:</h3>
                <a href="show_corce.php"><div class="round-button"><?php echo getCourseCount($conn); ?></div></a>
            </div>
            <div class="stat">
                <h3>Number of Teachers:</h3>
                <a href="show_teacher.php"><div class="round-button"><?php echo getTeacherCount($conn); ?></div></a>
            </div>
        </div>
        <div class="actions">
            <a href="add_course_form.php"><button>Add Course</button></a>
            <a href="add_teacher_form.php"><button>Add Teacher</button></a>
        </div>
    </div>
</body>
</html>
