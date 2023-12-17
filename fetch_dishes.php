<?php
include 'connection.php'; // Ensure this is the correct path to your connection file

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $dishes_query = mysqli_query($conn, "SELECT * FROM products WHERE category_id = '$category_id'");
    while ($dish = mysqli_fetch_assoc($dishes_query)) {
        echo "<p><a href='view_page.php?dish_id=".$dish['id']."'>".$dish['name']."</a></p>";
    }
}
?>
