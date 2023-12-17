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

if (isset($_POST['add_user'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    $check_email = mysqli_query($conn, "SELECT email FROM `users` WHERE email = '$new_email'");
    if(mysqli_num_rows($check_email) > 0){
        // $message[] = 'Email already exists!';
		$_SESSION['message'][] = 'Email already exists!';
    } else {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); 
        $new_user_type = mysqli_real_escape_string($conn, $_POST['new_user_type']);

        mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$new_name', '$new_email', '$new_password', '$new_user_type')") or die('query failed');
        $_SESSION['message'][] = 'User added successfully';
    }
}

// Handle user update
if(isset($_POST['update_user'])){
    $user_id = $_POST['user_id'];
    $updated_name = mysqli_real_escape_string($conn, $_POST['updated_name']);
    $updated_email = mysqli_real_escape_string($conn, $_POST['updated_email']);
    $updated_user_type = mysqli_real_escape_string($conn, $_POST['updated_user_type']);
    $update_query = "UPDATE `users` SET name = '$updated_name', email = '$updated_email', user_type = '$updated_user_type'";

    // Only update password if a new one was entered
    if(!empty($_POST['updated_password'])){
        $updated_password = password_hash($_POST['updated_password'], PASSWORD_DEFAULT);
        $update_query .= ", password = '$updated_password'";
    }

    $update_query .= " WHERE id = '$user_id'";
    mysqli_query($conn, $update_query) or die('query failed');
    $message[] = 'User updated successfully';
}

//delete users from database
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    $message[] = 'User removed successfully';
    header('location:admin_user.php');
}

if(isset($_GET['update'])){
    $update_id = $_GET['update'];
    $update_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$update_id'");
    if(mysqli_num_rows($update_query) == 1){
        $row_update = mysqli_fetch_assoc($update_query);
        $user_id = $row_update['id'];
        $current_name = $row_update['name'];
        $current_email = $row_update['email'];
        $current_user_type = $row_update['user_type'];
        // The update form code goes here (same as in your existing code)
    }
}

?>
<style type="text/css">
	<?php 
		include 'style.css';

	?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	
	<title>admin pannel</title>
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
		<h1 class="title">total user account</h1>
		<div class="box-container">
			<?php 
				$select_users = mysqli_query($conn,"SELECT * FROM `users`") or die('query failed');
				if (mysqli_num_rows($select_users)>0) {
					while($fetch_users = mysqli_fetch_assoc($select_users)){


			?>
			<div class="box">
				<p>user id: <span><?php echo $fetch_users['id']; ?></span></p>
				<p>name: <span><?php echo $fetch_users['name']; ?></span></p>
				<p>email: <span><?php echo $fetch_users['email']; ?></span></p>
				<p>user type : <span style="color:<?php if($fetch_users['user_type']=='admin'){echo 'orange';}; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
				<a href="admin_user.php?delete=<?php echo $fetch_users['id']; ?>;" onclick="return confirm('delete this message');" class="delete">delete</a>
				<a href="update_users.php?update=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Update this User');" class="update">update</a>
				



			</div>
			<?php 
					}
				}else{
						echo '
							<div class="empty">
								<p>no products added yet!</p>
							</div>
						';
				}		
			?>
		</div>

		<form action="admin_user.php" method="post">
		<input type="text" name="new_name" required placeholder="Name">
		<input type="email" name="new_email" required placeholder="Email">
		<input type="password" name="new_password" required placeholder="Password">
		<select name="new_user_type">
			<option value="admin">Admin</option>
			<option value="user">User</option>
		</select>
		<input type="submit" name="add_user" value="Add User">
	    </form>

	</section>
	<div class="line"></div>
	<script type="text/javascript" src="script.js"></script>
	
</body>
</html>