<?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include 'connection.php';

    $user_id = $_SESSION['user_id'] ?? null; // Null coalescing operator for user_id
    if (!$user_id) {
        header('Location: login.php');
        exit;
    }

    if (!isset($user_id)) {
        header('location:login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
    }
    //adding product in wishlist
    if (isset($_POST['add_to_wishlist'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        if (mysqli_num_rows($wishlist_number)>0) {
            $message[]='product already exist in wishlist';
        }else if (mysqli_num_rows($cart_num)>0) {
            $message[]='product already exist in cart';
        }else{
            mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
            $message[]='product successfuly added in your wishlist';
        }
    }

     //adding product in cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        if (mysqli_num_rows($cart_num)>0) {
            $message[]='product already exist in cart';
        }else{
            mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
            $message[]='product successfuly added in your cart';
        }
    }



    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while($fetch_products = mysqli_fetch_assoc($select_products)) {
                echo "<div class='dish-details'>";
                // Display dish details like image, name, price, etc.
                echo "</div>";

                


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
                    <div class="icon">
                        <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                        <input type="number" name="product_quantity" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                    </div>
                </div>
            </form>

          

            <div class="comment-form">
            <form action="comment_process.php" method="post">
            <textarea name="comment" required placeholder="Add a comment..."></textarea>
            <input type="hidden" name="dish_id" value="<?php echo $fetch_products['id']; ?>">
            <button type="submit" name="submit_comment">Post Comment</button>
            </form>
            </div>


           
                <?php    
                // Assuming this is within a loop where $fetch_products is defined
                // Code to display comments starts here
                echo '<div class="comments-section">';
                $comments = mysqli_query($conn, "SELECT comments.*, users.name, users.email FROM comments JOIN users ON comments.user_id = users.id WHERE dish_id = '".$fetch_products['id']."' ORDER BY created_at DESC");

                while ($comment = mysqli_fetch_assoc($comments)) {
                    echo "<div class='comment'>";
                    echo "<p>".htmlspecialchars($comment['name'])." (".htmlspecialchars($comment['email']).")</p>";
                    echo "<p>".htmlspecialchars($comment['comment'])."</p>";
                    echo "<p>Posted on: ".date('F j, Y, g:i a', strtotime($comment['created_at']))."</p>";

                    if ($comment['created_at'] != $comment['updated_at']) {
                        echo "<p>Last updated: ".date('F j, Y, g:i a', strtotime($comment['updated_at']))."</p>";
                    }

                    // User can edit or delete their own comments
                    if ($comment['user_id'] == $_SESSION['user_id']) {
                        echo "<a href='edit_comment.php?comment_id=".$comment['id']."'>Edit</a> ";
                        // echo "<a href='delete_comment.php?comment_id=".$comment['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    }

                    // Admin functionalities
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
                        // Admin can also delete any comment
                        echo "<a href='delete_comment.php?comment_id=".$comment['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    }

                    echo "</div>";
                }

                echo '</div>';


                ?>


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