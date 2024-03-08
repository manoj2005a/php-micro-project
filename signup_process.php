<?php
// Database connection
require("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $college = $_POST['college'];
    $number =$_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // File upload handling
    $target_directory = "uploads/"; // Directory where uploaded images will be saved
    $profile_image = $target_directory . basename($_FILES["profile_image"]["name"]); // Path to save the uploaded image
    $upload_ok = 1; // Flag to indicate whether the file was successfully uploaded

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Check file size
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $upload_ok = 0;
    }

    // Allow certain file formats
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    $file_extension = strtolower(pathinfo($profile_image, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_formats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Hash password before storing in database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, birthdate, address, college, profile_image, contact, `email`, password) VALUES ('$name', '$birthdate', '$address', '$college', '$profile_image','$number', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image)) {
                header('Location:login1.php ?');
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>
