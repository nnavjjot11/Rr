<?php
// Database connection
include 'admin_product.php'; // Replace with your database connection file

$productId = $_POST['id'];

// SQL to get the image path
$query = "SELECT image_path FROM products WHERE id = $productId";
// Execute the query and fetch the image path
// ...

// Remove the image file
unlink($imagePath);

// Update the database to indicate that the image has been removed
$updateQuery = "UPDATE products SET image_path = NULL WHERE id = $productId";
// Execute the update query
// ...

// Return a response
echo "Image removed successfully";
?>
