<?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include 'connection.php';

    // Assuming you have two separate session variables: one for regular users and one for admins
    $user_id = $_SESSION['user_id'] ?? null;
    $admin_id = $_SESSION['admin_id'] ?? null;
    
    // Check if a regular user or an admin is logged in
    if (!$user_id && !$admin_id) {
            header('Location: login.php');
            exit;
        }
    


        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT products.*, categories.name as category_name FROM products INNER JOIN categories ON products.category_id = categories.id WHERE products.id = '$pid'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    echo "<div class='dish-details'>";
               
                    // Displaying the category name
                    echo "</div>";
                    // Display dish details like image, name, price, etc.
                    
    
                    
    
    
                }
            }
        }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------------------bootstrap icon link------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>veggen - our shop</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Dish detail</h1>
            <p>Let's share your views on the dishes!</p>
            <a href="index.php">home</a><span>/ shop</span>
        </div>
    </div>
    <div class="line"></div>
    <!-----------------------about us------------------------>
    <section class="view_page">
        
        
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
        
            <?php 
                if (isset($_GET['pid'])) {
                    $pid = $_GET['pid'];
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
                    if (mysqli_num_rows($select_products)>0) {
                        while($fetch_products = mysqli_fetch_assoc($select_products)){
                        // Check if an image is associated with the product and display it
                        if (!empty($fetch_products['image'])) {
                            echo '<form class="view_page">';
                            echo '<img src="image/'.$fetch_products['image'].'" alt="Product Image">';
                            echo '</form>';
                        } else {
                            // Optionally, display a placeholder image or a message
                            echo '<p>No image available for this product.</p>';
                        }

            ?>
           


                <form method="post">
        <div class="detail">
            <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="detail"><?php echo $fetch_products['product_detail']; ?></div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
        </div>
    </form>



          


            <?php 
                        }
                    }
                }
   
            ?>
        
    </section>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>