<?php 
include 'connection.php';
session_start();


// Display session messages
if (isset($_SESSION['message'])) {
    foreach ($_SESSION['message'] as $message) {
        echo '<p class="message">' . htmlspecialchars($message) . '</p>';
    }
    // Clear the message after displaying
    unset($_SESSION['message']);
}

$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');  
    exit;
}

function resizeImage($file, $w, $h, $ext) {
    list($width, $height) = getimagesize($file);
    $src = ($ext == 'png') ? imagecreatefrompng($file) : imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
    return $dst;
}

function checkImageType($image_tmp_name) {
    $allowed_types = ['image/jpeg', 'image/png'];
    $detected_type = mime_content_type($image_tmp_name);
    return in_array($detected_type, $allowed_types) ? $detected_type : false;
}

// Adding products to database
if (isset($_POST['add_product'])) {
    // Fetch form data first
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'image/'.$image;
    $image_uploaded = false;

    if (!empty($image)) {
        $detected_type = checkImageType($image_tmp_name);
        if ($detected_type) {
            $ext = ($detected_type == 'image/png') ? 'png' : 'jpeg';
            $resized_image = resizeImage($image_tmp_name, 900, 900, $ext);
            $save_function = ($ext == 'png') ? 'imagepng' : 'imagejpeg';
            $save_function($resized_image, $image_folder);
            $image_uploaded = true;
        } else {
            $_SESSION['message'][] = 'Only JPEG and PNG files are allowed';
            header('location:admin_product.php');
            exit;
        }
    }

    // Insert query based on whether an image is uploaded
    $query = $image_uploaded ? 
        "INSERT INTO `products`(`name`, `price`, `product_detail`, `image`, `category_id`) VALUES ('$product_name', '$product_price', '$product_detail', '$image', '$category_id')" :
        "INSERT INTO `products`(`name`, `price`, `product_detail`, `category_id`) VALUES ('$product_name', '$product_price', '$product_detail', '$category_id')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'][] = 'Product added successfully';
    } else {
        $_SESSION['message'][] = 'Query failed: ' . mysqli_error($conn);
    }

    header('location:admin_product.php');
    exit;
}


    //delete products from database
	if (isset($_GET['delete'])) {
		$delete_id = $_GET['delete'];
		$select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
		$fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
		unlink('image/'.$fetch_delete_image['image']);

		mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
		mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

		header('location:admin_product.php');
	}


    if (isset($_POST['updte_product'])) {
        
        $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
        $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
        $update_price = mysqli_real_escape_string($conn, $_POST['update_price']);
        $update_category_id = mysqli_real_escape_string($conn, $_POST['update_category_id']);
        $update_detail = mysqli_real_escape_string($conn, $_POST['update_detail']);
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    
        $update_image_folder = 'image/' . $update_image;
    
        // Check for new image upload
    if (!empty($update_image)) {
        $detected_type = checkImageType($update_image_tmp_name);
        if ($detected_type) {
            $ext = ($detected_type == 'image/png') ? 'png' : 'jpeg';
            $resized_image = resizeImage($update_image_tmp_name, 900, 900, $ext);
            $save_function = ($ext == 'png') ? 'imagepng' : 'imagejpeg';
            
            if ($save_function($resized_image, $update_image_folder)) {
                // Update query with new image
                $update_query = "UPDATE `products` SET `name`='$update_name', `price`='$update_price', `product_detail`='$update_detail', `image`='$update_image', `category_id`='$update_category_id' WHERE id = '$update_id'";
            } else {
                $_SESSION['message'][] = 'Failed to save the new image.';
            }
        } else {
            $_SESSION['message'][] = 'Only JPEG and PNG files are allowed';
            header('location:admin_product.php');
            exit;
        }
    } else {
        // Update query without new image
        $update_query = "UPDATE `products` SET `name`='$update_name', `price`='$update_price', `product_detail`='$update_detail', `category_id`='$update_category_id' WHERE id = '$update_id'";
    }

    if (isset($update_query) && mysqli_query($conn, $update_query)) {
        $_SESSION['message'][] = 'Product updated successfully';
    } else {
        $_SESSION['message'][] = 'Failed to update product: ' . mysqli_error($conn);
    }

    header('location:admin_product.php');
    exit;
}
    
    


    if (isset($_POST['add_category'])) {
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
        if (!empty($category_name)) {
            $insert_category = mysqli_query($conn, "INSERT INTO `categories`(`name`) VALUES ('$category_name')");
            if ($insert_category) {
                $_SESSION['message'][] = 'Category added successfully';
            } else {
                $_SESSION['message'][] = 'Failed to add category';
            }
        } else {
            $_SESSION['message'][] = 'Category name is required';
        }
        header('location:admin_product.php');
        exit;
    }


     

    
    

       // Fetch categories and dishes from the database
       $categories_query = mysqli_query($conn, "SELECT * FROM categories");

?>




?>