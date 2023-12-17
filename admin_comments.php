<?php 

include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');  
}

// Delete comments from the database
if (isset($_GET['delete_comment'])) {
    $delete_id = $_GET['delete_comment'];
    
    mysqli_query($conn, "DELETE FROM `comments` WHERE id = '$delete_id'") or die('query failed');
    $message[] = 'Comment removed successfully';
    header('location:admin_comments.php');
}
?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--box icon link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
    <title>Admin Panel</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <?php 
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
            ';
        }
    }
    ?>
    <div class="line4"></div>
    <section class="message-container">
        <h1 class="title">User Comments</h1>
        <div class="box-container">
            <?php 
            // Modified SQL query to join the comments with products table
            $select_comments = mysqli_query($conn, "SELECT comments.id, comments.comment, users.name, users.email, products.name AS dish_name FROM comments JOIN users ON comments.user_id = users.id JOIN products ON comments.dish_id = products.id") or die('query failed');
            if (mysqli_num_rows($select_comments) > 0) {
                while($fetch_comments = mysqli_fetch_assoc($select_comments)){
            ?>
            <div class="box">
                <p>Comment ID: <span><?php echo $fetch_comments['id']; ?></span></p>
                <p>Dish Name: <span><?php echo $fetch_comments['dish_name']; ?></span></p> <!-- Display Dish Name -->
                <p>User Name: <span><?php echo $fetch_comments['name']; ?></span></p>
                <p>User Email: <span><?php echo $fetch_comments['email']; ?></span></p>
                <p>Comment: <span><?php echo $fetch_comments['comment']; ?></span></p>
                <a href="admin_comments.php?delete_comment=<?php echo $fetch_comments['id']; ?>" onclick="return confirm('Delete this comment?');" class="delete">delete</a>
            </div>
            <?php 
                }
            } else {
                echo '<div class="empty"><p>No comments found.</p></div>';
            }       
            ?>
        </div>
    </section>
    <div class="line"></div>
    <script type="text/javascript" src="script.js"></script>
    
</body>
</html>