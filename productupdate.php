<?php
// Include the database configuration file
include 'config.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: admin_log.php");
    exit();
}

// Initialize variables for status messages
$message = '';
$messageType = '';

// Start or resume session


// Check if there are flash messages from a previous request
if (isset($_SESSION['message']) && isset($_SESSION['messageType'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['messageType'];
    
    // Clear the flash messages
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate product name
    $productName = trim($_POST['product_name']);
    $productCategory = trim($_POST['product_category']);
    $productPrice = trim($_POST['product_price']);
    $productStock = trim($_POST['product_stock']);

    if (empty($productName)) {
        $_SESSION['message'] = "Product name is required";
        $_SESSION['messageType'] = "error";
    } else {
        // Sanitize product name for database
        $productName = htmlspecialchars($productName);
        $productCategory = htmlspecialchars($productCategory);
        $productPrice = htmlspecialchars($productPrice);
        $productStock = htmlspecialchars($productStock);
        
        // Check if file was uploaded
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            // Get file details
            $fileName = $_FILES['product_image']['name'];
            $fileTmpName = $_FILES['product_image']['tmp_name'];
            $fileSize = $_FILES['product_image']['size'];
            $fileType = $_FILES['product_image']['type'];

            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['message'] = "Only JPG, PNG, and GIF files are allowed";
                $_SESSION['messageType'] = "error";
            } 
            // Validate file size (limit to 2MB)
            elseif ($fileSize > 2000000) {
                $_SESSION['message'] = "File is too large (max 2MB)";
                $_SESSION['messageType'] = "error";
            } else {
                // Generate a unique filename to prevent overwriting
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = uniqid() . '.' . $fileExtension;
                
                // Define the upload directory (outside web root for better security)
                $uploadDir = 'Uploads/';
                
                // Ensure directory exists
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Define the full path
                $uploadPath = $uploadDir . $newFileName;
                
                // Move the file to the uploads directory
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Prepare SQL statement to prevent SQL injection
                    $stmt = $conn->prepare("INSERT INTO products (file, product_name, product_category, product_price, product_stock) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssdi", $newFileName, $productName, $productCategory, $productPrice, $productStock);
                    
                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Product added successfully";
                        $_SESSION['messageType'] = "success";
                    } else {
                        $_SESSION['message'] = "Database error: " . $conn->error;
                        $_SESSION['messageType'] = "error";
                    }
                    $stmt->close();
                } else {
                    $_SESSION['message'] = "Failed to upload image";
                    $_SESSION['messageType'] = "error";
                }
            }
        } else {
            $_SESSION['message'] = "Please select an image to upload";
            $_SESSION['messageType'] = "error";
        }
    }
    
    // Redirect to the same page to prevent form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        form {
            margin-bottom: 30px;
        }
        input, button {
            margin: 10px 0;
            padding: 8px;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-item {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Product Management</h1>
    
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" placeholder="Enter product name" >
        </div>
        <div>
            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" >
            <small>Max file size: 2MB. Allowed formats: JPG, PNG, GIF</small>
        </div>
        <div>
            <label for="product_category">Product Category:</label>
            <input type="text" id="product_category" name="product_category" placeholder="Enter product category">
        </div>

        <div>
            <label for="product_price">Product Price:</label>
            <input type="decimal" id="product_price" name="product_price" placeholder="Enter product price">
        </div>

        <div>
            <label for="product_stock">Product Stock:</label>
            <input type="number" id="product_stock" name="product_stock" placeholder="Enter product Stock">
        </div>
        <button type="submit" name="submit">Add Product</button>
    </form>
<button class = "delete"><a href="remove_product_form.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color:rgb(0, 0, 0);">Delete Products </a></button>
<button class = "delete"><a href="logoff_admin.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color:rgb(0, 0, 0);">Sign out </a></button>
    <h2>Product Gallery</h2>
    <div class="gallery">
        <?php
        // Prepare and execute a SELECT query
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY product_id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<img src="Uploads/' . htmlspecialchars($row['file']) . '" alt="' . htmlspecialchars($row['product_name'] ?? 'Product Image') . '">';
                echo '<p> Product Name:' . htmlspecialchars($row['product_name'] ?? 'No name') . '</p>';
                echo '<p> Product Category:' . htmlspecialchars($row['product_category'] ?? 'No name') . '</p>';
                echo '<p> Product Price:' . htmlspecialchars($row['product_price'] ?? 'No name') . '</p>';
                echo '<p> Product Stock:' . htmlspecialchars($row['product_stock'] ?? 'No name') . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found</p>';
        }
        $stmt->close();
        ?>
    </div>
</body>
</html>