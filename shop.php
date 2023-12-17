<?php 
    include 'connection.php';
    session_start();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    // Function to redirect to login if user is not logged in
    function redirectToLogin() {
        header("location: login.php");
        exit;
    }

    // Logout action
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
        exit;
    }

    // Adding product in wishlist
    if (isset($_POST['add_to_wishlist'])) {
        if (!$user_id) {
            redirectToLogin();
        }
        // ... rest of your add_to_wishlist code
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

    }

    // Adding product in cart
    if (isset($_POST['add_to_cart'])) {
        if (!$user_id) {
            redirectToLogin();
        }
        // ... rest of your add_to_cart code
    
    
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
            <h1>Our Dishes</h1>
            <p>Let's taste the most delicious Indian Dishes.</p>
            <a href="index.php">home</a>
        </div>
    </div>
    <div class="line"></div>
    <!-----------------------about us------------------------>
    <section class="shop">
        <h1 class="title">shop best sellers</h1>
        
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
        <div class="box-container">
            <?php 
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if (mysqli_num_rows($select_products)>0) {
                    while($fetch_products = mysqli_fetch_assoc($select_products)){


            ?>
            <form method="post" class="box">
                <img src="image/<?php echo $fetch_products['image']; ?>">
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_quantity" value="1" min="0">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>

            <?php 
                    }
                }else{
                    echo '<p class="empty">no products added yet!</p>';
                }
            ?>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>