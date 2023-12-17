<?php
// Start the session
session_start();

// Include your database connection file
include 'connection.php';

// Check if the user is logged in and the form is submitted
if(isset($_SESSION['user_id']) && isset($_POST['submit_comment'])) {
    // Get user ID from the session
    $user_id = $_SESSION['user_id'];

    // Sanitize and validate the inputs
    $dish_id = filter_input(INPUT_POST, 'dish_id', FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    // Check if inputs are not empty
    if(!empty($dish_id) && !empty($comment)) {
        // Prepare an SQL statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO comments (dish_id, user_id, comment) VALUES (?, ?, ?)");

        // Bind parameters to the SQL statement
        $stmt->bind_param("iis", $dish_id, $user_id, $comment);

        // Execute the statement
        if($stmt->execute()) {
            // Redirect back to the dish page or show success message
            header("Location: view_page.php?pid=$dish_id&comment_success=1");
            exit();
        } else {
            // Handle errors, e.g., connection issues, constraints violations etc.
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the error when input fields are empty
        header("Location: view_page.php?pid=$dish_id&error=empty_fields");
        exit();
    }
} else {
    // Redirect to login page or show an error if user is not logged in or form is not submitted
    header("Location: login.php");
    exit();
}

// Close the database connection
$conn->close();
?>
