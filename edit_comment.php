<?php
include 'connection.php';
session_start();

$comment = '';
$comment_id = '';
$referrer = $_SERVER['HTTP_REFERER'] ?? 'view_page.php'; // Default to view_page.php if referrer is not set

if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
    $query = "SELECT * FROM comments WHERE id = '$comment_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $comment = $row['comment'];

        if ($row['user_id'] != $_SESSION['user_id']) {
            echo "You do not have permission to edit this comment.";
            exit;
        }
    } else {
        echo "Comment not found.";
        exit;
    }
}

if (isset($_POST['update_comment'])) {
    $updated_comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $comment_id = $_POST['comment_id'];

    $update_query = "UPDATE comments SET comment = '$updated_comment' WHERE id = '$comment_id' AND user_id = '".$_SESSION['user_id']."'";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: " . $_POST['referrer'] . "?message=Comment updated successfully");
        exit;
    } else {
        echo "Error updating comment: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete_comment'])) {
    $delete_query = "DELETE FROM comments WHERE id = '$comment_id' AND user_id = '".$_SESSION['user_id']."'";
   

   if (mysqli_query($conn, $delete_query)) {
        header("Location: " . $_POST['referrer'] . "?message=Comment deleted successfully");
        exit;
    } else {
        echo "Error deleting comment: " . mysqli_error($conn);
    }
}
?>


<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #fcc927;
    padding: 20px;
}

form {
    max-width: 500px;
    margin: auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

textarea {
    width: 100%;
    height: 100px;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
    resize: vertical;
}

button {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #45a049;
}

input[type="hidden"] {
    display: none;
}

</style>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Comment</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <form method="post">
        <textarea name="comment"><?php echo htmlspecialchars($comment); ?></textarea>
        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment_id); ?>">
        <input type="hidden" name="referrer" value="<?php echo htmlspecialchars($referrer); ?>">
        <button type="submit" name="update_comment">Update Comment</button>
        <button type="submit" name="delete_comment">Delete Comment</button>
    </form>
</body>
</html>
