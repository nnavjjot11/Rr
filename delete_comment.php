<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit;
}

include 'connection.php'; // Make sure you have this file for database connection

$user_id = $_SESSION['user_id'];
$comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : null;

if (!$comment_id) {
    echo "No comment specified!";
    exit;
}

// Fetch the comment to verify ownership
$query = "SELECT * FROM comments WHERE id = '$comment_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $comment = mysqli_fetch_assoc($result);

    if ($comment['user_id'] == $user_id) {
        // The user owns the comment, proceed to delete
        $delete_query = "DELETE FROM comments WHERE id = '$comment_id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "Comment deleted successfully!";
            // Redirect to previous page or indicate success
            header("Location: view_page.php"); // Adjust the redirection as per your page structure
        } else {
            echo "Error deleting comment: " . mysqli_error($conn);
        }
    } else {
        echo "You do not have permission to delete this comment.";
    }
} else {
    echo "Comment not found.";
}

mysqli_close($conn);

?>
