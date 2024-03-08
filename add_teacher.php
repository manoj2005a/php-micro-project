<?php
require("connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $teacher_name = $conn->real_escape_string($_POST['teacher-name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $check_query = "SELECT * FROM teachers WHERE email = '$email'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
     
        header('Location: add_teacher_form.php?message_type=error&message_content=Error:%20Teacher%20already%20exists.');
        exit();
    }

  
    $sql = "INSERT INTO teachers (teacher_name, email, phone) VALUES ('$teacher_name', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
     
        header('Location: add_teacher_form.php?message_type=success&message_content=Teacher%20added%20successfully!');
        exit();
    } else {
       
        header('Location: add_teacher_form.php?message_type=error&message_content=Error:%20' . $conn->error);
        exit();
    }
}


$conn->close();
?>
