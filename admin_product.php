<?php 
include 'connection.php';
session_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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


     if (isset($_GET['delete_category'])) {
        $category_id = mysqli_real_escape_string($conn, $_GET['delete_category']);
        mysqli_query($conn, "DELETE FROM categories WHERE id = '$category_id'");
        header('location:admin_product.php');
        exit;
    }
    

    if (isset($_POST['update_category'])) {
        $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
        $updated_category_name = mysqli_real_escape_string($conn, $_POST['updated_category_name']);
    
        mysqli_query($conn, "UPDATE categories SET name = '$updated_category_name' WHERE id = '$category_id'");
        header('location:admin_product.php');
        exit;
    }

    if(isset($_GET['remove_image'])) {
        $product_id = $_GET['remove_image'];
    
        // Perform validation here (e.g., ensure the user has the right to remove an image)
    
        // Fetch the current image name from the database
        $query = "SELECT image FROM products WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $image_name = $row['image'];
    
                // Delete the image file from the server
                if (!empty($image_name)) {
                    $file_path = "path/to/your/image/directory/" . $image_name; // Update with your image directory path
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
    
                // Update the database to remove the image reference
                $update_query = "UPDATE products SET image = NULL WHERE id = ?";
                if ($update_stmt = $conn->prepare($update_query)) {
                    $update_stmt->bind_param("i", $product_id);
                    $update_stmt->execute();
    
                    // Redirect or show a success message
                    echo "Image removed successfully!";
                    header("Location: admin_product.php"); // Uncomment to redirect
                } else {
                    // Handle error
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                // Product not found or more than one product found
                echo "Product not found or multiple entries detected.";
            }
            $stmt->close();
        } else {
            // Handle error
            echo "Error preparing the statement: " . $conn->error;
        }
    }
    
	   // Add this code to handle the sorting logic
	   $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
	   $order = isset($_GET['order']) && in_array($_GET['order'], ['ASC', 'DESC']) ? $_GET['order'] : 'ASC';

       // Fetch categories and dishes from the database
       $categories_query = mysqli_query($conn, "SELECT * FROM categories");

?>

<style type="text/css">
	<?php 
		include 'style.css';

	?>
.show-categories {
    margin-top: 0;
    margin: 20px 0;
    padding: 10px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
}

.category {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px;
    border-bottom: 1px solid #eee;
}

.category:last-child {
    border-bottom: none;
}

.category span {
    font-size: 16px;
    color: #333;
}

.category .btn {
    padding: 6px 12px;
    color: red; /* White text color */
    text-decoration: none;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s; /* Smooth background color transition */
}



/* Ensure that the html and body tags span the full height of the browser window */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

/* Style the sidebar */
.sidebar {
    position: fixed; /* Fixed position */
    top: 0; /* Start at the top of the page */
    left: 0; /* Align to the left side of the page */
    width: 250px; /* Width of the sidebar */
    height: 100%; /* Full height */
    background-color: #f0f0f0; /* Background color of the sidebar */
    overflow-y: auto; /* Enable scrolling if content is longer than the screen */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional: adds shadow to right side of sidebar */
    z-index: 1000; /* Ensures the sidebar stays on top of other content */
}

/* Style the category list */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Style the links */
.categories-list a, .dishes-list a {
    text-decoration: none;
    color: #333;
    display: block;
    padding: 5px 0;
}

/* Style the nested dishes list */
.dishes-list {
    list-style: none;
    padding-left: 20px; /* Indent the dishes list for better visual hierarchy */
}

/* Optional: Change the background color of list items on hover */
.categories-list li:hover, .dishes-list li:hover {
    background-color: #e9e9e9;
}

/* Optional: Style the category headers */
.sidebar h3 {
    padding: 15px;
    margin: 0;
    background-color: #ddd; /* Header background color */
    color: #333;
    text-align: center;
}

/* Closed state of the sidebar */
.sidebar.closed {
    left: -250px; /* Hide sidebar off-screen */
}

/* Toggle button style */
.sidebar-toggle {
    position: fixed;
    top: 10px; /* Position where it is easy to reach */
    left: 250px; /* Adjust as needed */
    z-index: 1001; /* Above the sidebar */
    cursor: pointer;
    padding: 10px 15px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
}





</style>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet">

	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>


	
	<title>admin pannel</title>
</head>
<body>
	<?php include 'admin_header.php'; ?>
	<?php 
    if (isset($_SESSION['message'])) {
        foreach ($_SESSION['message'] as $message) {
            echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove();"></i>
                </div>
            ';
        }
        unset($_SESSION['message']); // Clear the message after displaying
    }
?>
        
        <aside class="sidebar">
    <h3>Categories</h3>
    <ul class="categories-list">
        <?php while ($category = mysqli_fetch_assoc($categories_query)): ?>
            <li>
                <a href="category.php?cid=<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
                <ul class="dishes-list">
                    <?php
                    $category_id = $category['id'];
                    $dishes_query = mysqli_query($conn, "SELECT * FROM products WHERE category_id = '$category_id'");
                    while ($dish = mysqli_fetch_assoc($dishes_query)): ?>
                        <li>
                            <!-- Link to view_page.php with the dish ID as a query parameter -->
                            <a href="view_dish.php?pid=<?php echo $dish['id']; ?>">
                                <?php echo htmlspecialchars($dish['name']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
        <?php endwhile; ?>
    </ul>
</aside>



    



	<div class="line2"></div>
    <button class="sidebar-toggle">Close Menu</button>

	
	<section class="add-products form-container">
		<form method="POST" action="" enctype="multipart/form-data">
 			<div class="input-field">
				<label>Dish name</label>
				<input type="text" name="name" required>
			</div>

        
            <div class="input-field">
                <label>Category</label>
                <select name="category_id">
                    <?php 
                    $query = mysqli_query($conn, "SELECT * FROM categories");
                    while($row = mysqli_fetch_assoc($query)){
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>



			<div class="input-field">
				<label>Dish price</label>
				<input type="text" name="price" required>
			</div> 

			<label>Dish Details</label>
			<div class="input-field">
    		<div id="editor"></div>
    		<input type="hidden" name="detail" id="hidden-detail">
			</div>

            			
			<div class="input-field">
				<label>Dish image</label>
				<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
			</div>
			<input type="submit" name="add_product" value="add product" class="btn">
		 </form>
	</section>
    <button id="closeButton" style="display:none;">Close Form</button>
    
 


			<script>
            document.addEventListener('DOMContentLoaded', function() {
            let toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                // ... additional toolbar options
            ];

            // Initialize Quill for the 'Add Product' form
            if (document.getElementById('editor')) {
                let addQuill = new Quill('#editor', {
                    modules: { toolbar: toolbarOptions },
                    theme: 'snow'
                });

                let addForm = document.querySelector('.add-products form');
                addForm.onsubmit = function() {
                    document.getElementById('hidden-detail').value = addQuill.root.innerHTML;
                };
            }

            // Initialize Quill for the 'Update Product' form
            if (document.getElementById('update_editor')) {
                let updateQuill = new Quill('#update_editor', {
                    modules: { toolbar: toolbarOptions },
                    theme: 'snow'
                });

                // Set the Quill editor's content to the existing detail
                let existingDetail = document.getElementById('update_editor').textContent;
                updateQuill.clipboard.dangerouslyPasteHTML(existingDetail);

                let updateForm = document.querySelector('.update-container form');
                updateForm.onsubmit = function() {
                    document.getElementById('update_hidden-detail').value = updateQuill.root.innerHTML;
                };
            }
        });


            </script>

        <section class="add-category form-container">
            <form method="POST" action="">
                <div class="input-field">
                    <label>Category Name</label>
                    <input type="text" name="category_name" required>
                </div>
                <input type="submit" name="add_category" value="Add Category" class="btn">
            </form>
        </section>

        <section class="show-categories">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM categories");
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<div class='category'>";
            echo "<span>" . htmlspecialchars($row['name']) . "</span>";
            echo "<a href='admin_product.php?delete_category=" . $row['id'] . "' class='btn'>Delete</a>";
            echo "<a href='admin_product.php?edit_category=" . $row['id'] . "' class='btn'>Edit</a>";
            echo "</div>";
        }
        ?>
        </section> 

        <?php    if (isset($_GET['edit_category'])) {
        $category_id = mysqli_real_escape_string($conn, $_GET['edit_category']);
        $edit_query = mysqli_query($conn, "SELECT * FROM categories WHERE id = '$category_id'");
        if ($row = mysqli_fetch_assoc($edit_query)) {
            // Display edit form
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='category_id' value='" . $row['id'] . "'>";
            echo "<input type='text' name='updated_category_name' value='" . $row['name'] . "'>";
            echo "<input type='submit' name='update_category' value='Update Category'>";
            echo "</form>";
        }
    }  ?>


			

	<section class="sorting">
    <form action="admin_product.php" method="GET">
        <select name="sort_by">
            <option value="name">Name</option>
            <option value="created_at">Date Created</option>
            <option value="price">Price</option>
        </select>
        <select name="order">
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>
        <input type="submit" value="Sort">
    </form>
    </section>

	<section class="show-products">
    <div>Sorting by: <?php echo htmlspecialchars($sort_by); ?>, Order: <?php echo htmlspecialchars($order); ?></div>
    <!-- Your existing code for displaying products -->


	<section class="update-container">
		<?php 
			if (isset($_GET['edit'])) {
				$edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die('query failed');
                $category_query = mysqli_query($conn, "SELECT * FROM `categories`"); // Fetch all categories
				if (mysqli_num_rows($edit_query)>0) {
					while($fetch_edit = mysqli_fetch_assoc($edit_query)){  
       ?>

        <form method="POST" enctype="multipart/form-data">
            <img src="image/<?php echo $fetch_edit['image']; ?>" alt="Product Image">
            <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
            <input type="text" name="update_name" value="<?php echo $fetch_edit['name']; ?>">
            <input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price']; ?>">

            <div class="input-field">
                <label>Category</label>
                <select name="update_category_id">
                    <?php 
                    while ($row = mysqli_fetch_assoc($category_query)) {
                        $selected = ($fetch_edit['category_id'] == $row['id']) ? 'selected' : '';
                        echo "<option value='".$row['id']."' $selected>".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>

            <input type="hidden" name="update_detail" id="update_hidden-detail">
            <div id="update_editor" class="editor"><?php echo htmlspecialchars($fetch_edit['product_detail']); ?></div>

            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp">
            <input type="submit" name="updte_product" value="update" class="edit">
            <input type="reset" value="cancel" class="option-btn btn" id="close-form">
        </form>


		<?php 
					}
				}
				echo "<script>document.querySelector('.update-container').style.display='block'</script>";
			}
		?>
	</section>

	</section>

	<div class="line3"></div>
	<div class="line4"></div>
	<section class="show-products">
		<div class="box-container">
			<?php 
                $select_products = mysqli_query($conn, "SELECT products.*, categories.name as category_name FROM `products` INNER JOIN categories ON products.category_id = categories.id ORDER BY `$sort_by` $order");
				if (mysqli_num_rows($select_products)>0) {
					while($fetch_products = mysqli_fetch_assoc($select_products)){

			?>
			<div class="box">
				<img src="image/<?php echo $fetch_products['image']; ?>">
				<p>price : $<?php echo $fetch_products['price']; ?> </p>
				<h4><?php echo $fetch_products['name']; ?></h4>
                <p>Category: <?php echo htmlspecialchars($fetch_products['category_name']); ?></p>
				<details><?php echo $fetch_products['product_detail']; ?></details>
				<a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">edit</a>
				<a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('want to delete this product');">delete</a>
                <?php if (!empty($fetch_products['image'])) { ?>
                <a href="admin_product.php?remove_image=<?php echo $fetch_products['id']; ?>" class="remove-image" onclick="return confirm('want to remove the image of this product');">remove image</a>
                <?php } ?>
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
	</section>
	<div class="line"></div>
    <script>
        document.querySelector('.update-container form').onsubmit = function() {
        document.getElementById('update_hidden-detail').value = document.querySelector('#update_editor .ql-editor').innerHTML;
    };

    </script>

    <script>
        // JavaScript to toggle the sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleButton = document.querySelector('.sidebar-toggle');

            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('closed');
                // Update button text/content based on the state
                if (sidebar.classList.contains('closed')) {
                    toggleButton.textContent = 'Open Menu';
                } else {
                    toggleButton.textContent = 'Close Menu';
                }
            });
        });
    </script>




	
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
		const closeBtn = document.querySelector('#close-form');

closeBtn.addEventListener('click',()=>{
    document.querySelector('.update-container').style.display='none'
})
	</script>


</body>
</html> 