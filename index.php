<?php 
include 'connection.php';
session_start();

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Logout logic remains the same
if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit;
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
    		$message[]='Dish already exist in wishlist';
    	}else if (mysqli_num_rows($cart_num)>0) {
    		$message[]='Dish already exist in cart';
    	}else{
    		mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
    		$message[]='Dish successfuly added in your wishlist';
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
    		$message[]='Dish already exist in cart';
    	}else{
    		mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
    		$message[]='Dish successfuly added in your cart';
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
    <!------------------------bootstrap css link------------------------------->
    <!------------------------slick slider link------------------------------->
    <link rel="stylesheet" type="text/css" href="slick.css" />
    <!------------------------default css link------------------------------->
    <link rel="stylesheet" href="main.css">
    <title>veggen - home page</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <!------------------------hero img container------------------------------->

    <div class="container-fluid">
        <div class="hero-slider">
            <div class="slider-item">
                <img src="img/slider.jpg" alt="...">
                <div class="slider-caption">
                    <span style="color: black; font-weight: bold;">Taste The Quality</span>
                    <h1>Indian Chronicles <br>Restaurant</h1>
                    <p>Welcome to Indian Chronicles,<br>
					 a culinary oasis in the heart <br>
					 of Winnipeg,where authentic <br>
					 flavors meet contemporary flair,<br> 
					 offering an unforgettable journey <br>
					 through India's rich culinary heritage. </p>
                    <a href="" class="btn">shop now</a>
                </div>
            </div>
            <div class="slider-item">
                <img src="img/slider2.png" alt="...">
                <div class="slider-caption">
                    <span style="color: black; font-weight: bold;">Taste The Quality</span>
                    <h1>Best Indian <br> Desserts<br></h1>
                    <p> Experience the enchantment <br> 
					of Indian desserts, <br>
					a rich tapestry of flavors that <br>
					 blend tradition <br>
					with sweetness. From the creamy Kulfi <br>
					to the luscious Gulab Jamun, <br>
					each bite is a journey through India's<br>
					culinary heritage.Indulge in these <br>
					sweet delights and savor the taste of India! </p>
                    <a href="" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <div class="control">
            <i class="bi bi-chevron-left prev"></i>
            <i class="bi bi-chevron-right next"></i>
        </div>
    </div>


<!--     <div class="line2"></div>
    <div class="story">
    	<div class="row">
    		<div class="box">
    			<span style="font-color: black; font-weight: bold;">Our story</span>
    			<h1>Service of Indian Food since 1990</h1>
    			<p>In the heart of Winnipeg, Indian Chronicles has been a culinary beacon since 1995,
					 offering an authentic taste of India's rich flavors and spices. A family-owned gem, 
					 it's a place where every dish tells a story of tradition and passion, 
					 inviting diners on a memorable journey of taste and culture.</p>
                <a href="shop.php" class="btn">Order now</a>
    		</div>
    		<div class="box">
    			<img src="img/8.png">
    		</div>
    	</div>
    </div> -->
    
    <!-- testimonial -->
   
    
    <!---discover section --->
    <div class="line2"></div>
    <div class="discover">
    	<div class="detail">
    		<h1 class="title">Best Indian Food on Special Offer!</h1>
    		<span>Order Now And Save 30% Off!</span>
    		<p>Indulge in the exquisite flavors of Indian Chronicles and enjoy an unbeatable offer! 
				Order now and receive a staggering 30% off on your meal. Don't miss this chance to savor 
				authentic Indian delicacies at a fraction of the cost. 
				Hurry, this tempting deal is just a click away!</p>
            <a href="shop.php" class="btn">Order now</a>
    	</div>
    	<!-- <div class="img-box">
    		<img src="img/13.png">
    	</div> -->
    </div>

    <div class="line"></div>
    
    <?php include 'homeshop.php'; ?>
    <div class="line2"></div>+
    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <script src="jquary.js"></script>
    <script src="slick.js"></script>

    <script type="text/javascript">
        <?php include 'script2.js' ?>
    </script>
</body>

</html>