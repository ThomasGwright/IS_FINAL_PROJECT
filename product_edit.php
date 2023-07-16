<?php
// Start the session and check if the employee is logged in
session_start();
if (!isset($_SESSION["employee_id"])) {
    // Redirect to the login page if the employee is not logged in
    header("Location: employee_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Edit</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the product_edit page */
        /* Add your custom styles here */
        body {
            background-color: #333333;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        
        h3 {
            margin: 20px 0;
            color: #333333;
        }
        
        form {
            text-align: left;
            margin-bottom: 20px;
        }
        
        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        
        form input[type="submit"] {
            width: auto;
            display: inline-block;
            background-color: #44a17e;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .product {
            margin-bottom: 20px;
        }
        
        .product h4 {
            margin: 0;
            color: #333333;
        }
        
        .product p {
            margin: 5px 0;
            color: #666666;
        }
        
        .product img {
            max-width: 200px;
            margin-bottom: 10px;
        }
        
        .header {
            background-color: #f2f2f2;
            padding: 10px;
            overflow: auto;
        }
        
        .left-buttons,
        .right-buttons {
            display: flex;
            align-items: center;
        }
        
        .left-buttons a,
        .right-buttons a {
            display: inline-block;
            padding: 10px 20px;
            color: #333333;
            text-decoration: none;
        }
        
        .right-buttons a {
            background-color: #ff7f7f;
            color: #ffffff;
            border-radius: 5px;
        }
        
        .right-buttons a:hover {
            background-color: #e66969;
        }
        
        .menu {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        .menu a {
            margin-right: 10px;
            color: #333333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header class="sticky-header">
        <div class="left-buttons">
            <a href="index.php" class="button">Home</a>
            <a href="product_catalog.php" class="button">Products</a>
        </div>
        <div class="right-buttons">
            <?php
            // Check if an employee is logged in
            if (isset($_SESSION["employee_id"])) {
                
                // If employee logged in, display the logout button and employee's name
                echo '<form action="employee_login_success.php" method="POST">';
                echo '<button type="Admin" name="Admin" class="button">Admin</button>';
                echo '<form action="logout.php" method="POST">';
                echo '<button type="submit" name="logout" class="button">Logout</button>';
                echo '</form>';
                echo '<span>Welcome ' . $_SESSION["employee_name"] . '</span>';
                 

            } else {
                // If not logged in, display the login and register buttons
                echo '<a href="customer_login.php" class="button">Login</a>';
                echo '<a href="customer_registration.php" class="button">Register</a>';
            }
            ?>
            <a href="cart.php" class="button">Cart</a>
        </div>
    </header>
    <div class="container">
        <?php
        // Connect to the "project" database
        $servername = "localhost:8889";
        $username = "root";
        $password = "root";
        $database = "project";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete product
        if (isset($_POST['delete_product'])) {
            $productId = $_POST['product_id'];

            // Prepare and execute the SQL statement to delete the product
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();

            // Redirect to the product_edit page
            header("Location: product_edit.php");
            exit();
        }

        // Add new product
        if (isset($_POST['add_product'])) {
            $productName = $_POST['product_name'];
            $productDescription = $_POST['product_description'];
            $productPrice = $_POST['product_price'];

            // File upload
            $targetDir = "uploads/";
            $fileName = basename($_FILES["product_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Check if file is a valid image
            $validImageTypes = array("jpg", "jpeg", "png", "gif");
            if (in_array($fileType, $validImageTypes)) {
                // Move uploaded file to the target directory
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)) {
                    // Prepare and execute the SQL statement to add the product
                    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, employee_id) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssdsi", $productName, $productDescription, $productPrice, $targetFilePath, $_SESSION["employee_id"]);
                    $stmt->execute();

                    // Redirect to the product_edit page
                    header("Location: product_edit.php");
                    exit();
                } else {
                    echo "Error uploading the image.";
                }
            } else {
                echo "Invalid image file.";
            }
        }

        // Fetch existing products from the database
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        ?>
        
        <h2>Product Edit</h2>

        <!-- Add New Product Form -->
        <h3>Add New Product:</h3>
        <form action="product_edit.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <br>
            <input type="text" name="product_description" placeholder="Product Description" required>
            <br>
            <input type="number" name="product_price" placeholder="Product Price" required>
            <br>
            <input type="file" name="product_image" accept="image/*" required>
            <br>
            <input type="submit" name="add_product" value="Add Product">
        </form>

        <!-- Existing Products List -->
        <h3>Existing Products</h3>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h4>' . $row["name"] . '</h4>';
                echo '<p>' . $row["description"] . '</p>';
                echo '<p>Price: $' . $row["price"] . '</p>';
                echo '<img src="' . $row["image"] . '" alt="Product Image">';
                echo '<form action="product_edit.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '<input type="submit" name="delete_product" value="Delete">';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }
        ?>

        <?php
        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
