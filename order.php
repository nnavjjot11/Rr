<?php 
    include 'connection.php';
    session_start();

    // Redirects if not logged in
    if (!isset($_SESSION['user_id'])) {
        header('location:login.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Logout functionality
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
        exit();
    }

    // Message submission handling
    if (isset($_POST['submit-btn'])) {
        // Data sanitization and preparation
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Use prepared statements for better security
        $stmt = $conn->prepare("INSERT INTO `message`(`user_id`, `name`, `email`, `number`, `message`) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $name, $email, $number, $message);
        if($stmt->execute()){
            echo "<script>alert('Message sent successfully');</script>";
        } else {
            echo "<script>alert('Failed to send message');</script>";
        }
        $stmt->close();
    }

    // Order deletion handling
    if(isset($_GET['delete_order'])) {
        $order_id = $_GET['delete_order'];

        // Security: Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM `orders` WHERE order_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        if($stmt->execute()) {
            echo "<script>alert('Order deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete order');</script>";
        }
        $stmt->close();
        header('location: order.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Order Page</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Order</h1>
            <p>Let's order your favourite dish!</p>
            <a href="index.php">Home</a><span> / Order</span>
        </div>
    </div>
    <div class="line"></div>
    <div class="order-section">
    <div class="box-container">
            <?php 
            
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'");
            if ($select_orders && mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            
            ?>
            
            <div class="box">
                <p>Placed on: <span><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></span></p>
                <p>Name: <span><?php echo htmlspecialchars($fetch_orders['name']); ?></span></p>
                <p>Number: <span><?php echo htmlspecialchars($fetch_orders['number']); ?></span></p>
                <p>Email: <span><?php echo htmlspecialchars($fetch_orders['email']); ?></span></p>
                <p>Address: <span><?php echo htmlspecialchars($fetch_orders['address']); ?></span></p>
                <p>Payment method: <span><?php echo htmlspecialchars($fetch_orders['method']); ?></span></p>
                <p>Your order: <span><?php echo htmlspecialchars($fetch_orders['total_products']); ?></span></p>
                <p>Total price: <span><?php echo htmlspecialchars($fetch_orders['total_price']); ?></span></p>
                <p>Payment status: <span><?php echo htmlspecialchars($fetch_orders['payment_status']); ?></span></p>
                <a href="order.php?delete_order=<?php echo htmlspecialchars($fetch_orders['order_id']); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete Order</a>
            </div>
            
            <?php
                }
            } else {
                echo '<div class="empty"><p>No orders placed yet!</p></div>';
            }
            ?>
    
    </div>

            
    
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>

</body>

</html>
