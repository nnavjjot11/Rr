<?php
include 'admin_product.php';  // Adjust this line as per your actual connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    // Sanitize and validate $categoryName if needed

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute(['name' => $categoryName]);

    // Optionally, add a success message or redirection after insertion
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $categoryId = $_POST['delete'];
    // Sanitize and validate $categoryId if needed

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute(['id' => $categoryId]);

    // Optionally, add a success message or redirection after deletion
}

echo '<form method="post">'; 
echo '<input type="text" name="categoryName" required>';
echo '<input type="submit" value="Add Category">';
echo '</form>';


$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $category) {
    echo htmlspecialchars($category['name']);
    echo '<form method="post"><button type="submit" name="delete" value="'. htmlspecialchars($category['id']) .'">Delete</button></form>';
}



?>