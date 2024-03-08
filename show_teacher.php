<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
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
        <h2>Teacher Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Teacher ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the connection file
                require("connection.php");

                // Handle delete operation
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_teacher'])) {
                    if(isset($_POST['id'])){
                        $teacher_id = $_POST['id'];
                        $sql = "DELETE FROM teachers WHERE id = '$teacher_id'";
                        if ($conn->query($sql) === TRUE) {
                            echo "<script>alert('Teacher deleted successfully');</script>";
                        } else {
                            echo "<script>alert('Error deleting teacher: " . $conn->error . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Teacher ID not provided');</script>";
                    }
                }

                // Fetch teachers data from the database
                $sql = "SELECT * FROM teachers";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['teacher_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>";
                        echo "<form method='post'>";
                        if(isset($row['id'])){
                            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='delete_teacher' onclick=\"return confirm('Are you sure you want to delete this teacher?');\">Delete</button>";
                        } else {
                            echo "Teacher ID not provided";
                        }
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No teachers found</td></tr>";
                }

                // Close the connection
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="add_teacher_form.php">Add New Teacher</a>
    </div>
</body>
</html>
