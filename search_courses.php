<?php
// Check if search query is provided
if(isset($_GET['query'])) {
    // Get the search query
    $search_query = $_GET['query'];

    // Database connection
    require("connection.php");

    // Search for courses by name or ID
    $sql = "SELECT * FROM courses WHERE course_name LIKE '%$search_query%' OR id = '$search_query'";
    $result = $conn->query($sql);

    // Check if any course found
    if ($result->num_rows > 0) {
        // Fetch the first course found (assuming there's only one course with the same name or ID)
        $row = $result->fetch_assoc();
        $course_id = $row['id'];
        
     
        header("Location: course_details.php?course_id=$course_id");
        exit();
    } else {
     
        header("Location: index.php?error=Course not found");
        exit();
    }

    $conn->close();
} else {
   
    header("Location: index.php");
    exit();
}
?>
