<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add Teacher</h2>
        <?php
        // Check if error or success message is passed through URL parameters
        if (isset($_GET['message_type']) && isset($_GET['message_content'])) {
            $message_type = $_GET['message_type'];
            $message_content = $_GET['message_content'];
            if ($message_type === 'error') {
                echo "<div class='error'>$message_content</div>";
            } elseif ($message_type === 'success') {
                echo "<div class='success'>$message_content</div>";
            }
        }
        ?>
        <form action="add_teacher.php" method="post">
            <div class="form-group">
                <label for="teacher-name">Teacher Name:</label>
                <input type="text" id="teacher-name" name="teacher-name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <button type="submit">Add Teacher</button>
        </form>
    </div>
</body>
</html>
