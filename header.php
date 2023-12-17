<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<title>Document</title>
</head>
<body>
	<header class="header">
		<div class="flex">
			<a href="index.php" class="logo"><img src="img/logo.png"></a>
			<nav class="navbar">
				<a href="index.php">Home</a>
				<!-- <a href="about.php">About us</a> -->
				<a href="shop.php">Dishes</a>
				<!-- <a href="comments.php">Comments</a> -->
				<!-- <a href="order.php">Order</a> -->
				<a href="contact.php">Contact</a>
			</nav>
			<div class="icons">
				<i class="bi bi-person" id="user-btn"></i>
				<?php 
					$select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die ('query failed');
					$wishlist_num_rows = mysqli_num_rows($select_wishlist);
				?>
				<a href="wishlist.php"><i class="bi bi-heart"></i><sup><?php echo $wishlist_num_rows; ?></sup></a>
				<?php 
					$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die ('query failed');
					$cart_num_rows = mysqli_num_rows($select_cart);
				?>
				<a href="cart.php"><i class="bi bi-cart"></i><sup><?php echo $cart_num_rows; ?></sup></a>
				<a href="login.php" class="login-icon">
    				<i class="bi bi-box-arrow-in-right"></i>
				</a>
				<i class="bi bi-list" id="menu-btn"></i>
			</div>


			<div class="user-box">
			<?php if(isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
				<p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
				<p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
				<form method="post">
					<button type="submit" name="logout" class="logout-btn">log out</button>
				</form>
			<?php else: ?>
				<!-- Display alternative content for non-logged in users, or nothing -->
				<p>You are not logged in!</p>
			<?php endif; ?>
		    </div>

		</div>
	</header>
	
</body>
</html>