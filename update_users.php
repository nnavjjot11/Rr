<?php

include 'connection.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

$message = [];

// Fetch user data to pre-fill the form
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$update_id'");
    if (mysqli_num_rows($update_query) == 1) {
        $row_update = mysqli_fetch_assoc($update_query);
    } else {
        header('location:admin_user.php');
        exit;
    }
}

// Handle the update form submission
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $updated_name = mysqli_real_escape_string($conn, $_POST['updated_name']);
    $updated_email = mysqli_real_escape_string($conn, $_POST['updated_email']);
    $updated_user_type = mysqli_real_escape_string($conn, $_POST['updated_user_type']);

    $update_query = "UPDATE `users` SET name = '$updated_name', email = '$updated_email', user_type = '$updated_user_type'";

    // Update password if provided
    if (!empty($_POST['updated_password'])) {
        $updated_password = password_hash($_POST['updated_password'], PASSWORD_DEFAULT);
        $update_query .= ", password = '$updated_password'";
    }

    $update_query .= " WHERE id = '$user_id'";
    mysqli_query($conn, $update_query) or die(mysqli_error($conn));
    header('location:admin_user.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <!-- Add your stylesheet link here -->
    <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .update-form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        form a {
            text-decoration: none;
            color: #555;
        }

        form a:hover {
            text-decoration: underline;
        }
        </style>
</head>
<body>
    <div class="update-form-container">
        <form action="update_users.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $row_update['id']; ?>">
            <input type="text" name="updated_name" value="<?php echo $row_update['name']; ?>" required>
            <input type="email" name="updated_email" value="<?php echo $row_update['email']; ?>" required>
            <input type="password" name="updated_password" placeholder="Enter new password (optional)">
            <select name="updated_user_type">
                <option value="admin" <?php echo ($row_update['user_type'] == "admin" ? "selected" : ""); ?>>Admin</option>
                <option value="user" <?php echo ($row_update['user_type'] == "user" ? "selected" : ""); ?>>User</option>
            </select>
            <input type="submit" name="update_user" value="Update User">
        </form>
    </div>
</body>
</html>
