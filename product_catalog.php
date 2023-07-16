<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Product Catalog</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .logo-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 2in;
            height: 2in;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }

        .logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
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
            // Check if the session is active
            if (isset($_SESSION["customer_id"])) {
                // If customer logged in, display the logout button and customer's name
                echo '<form action="logout.php" method="POST">';
                echo '<button type="submit" name="logout" class="button">Logout</button>';
                echo '</form>';
                echo '<span>Welcome ' . $_SESSION["customer_name"] . '</span>';
            } elseif (isset($_SESSION["employee_id"])) {
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
        <h2>Product Catalog</h2>

        <?php
        // Connect to the "project" database
        $productServername = "localhost";
        $productUsername = "root";
        $productPassword = "root";
        $productDatabase = "project";

        $productConn = new mysqli($productServername, $productUsername, $productPassword, $productDatabase);
        if ($productConn->connect_error) {
            die("Connection to project database failed: " . $productConn->connect_error);
        }

        // Fetch products from the project database
        $productSql = "SELECT * FROM products";
        $productResult = $productConn->query($productSql);

        if ($productResult->num_rows > 0) {
            while ($productRow = $productResult->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h3>' . $productRow["name"] . '</h3>';
                echo '<img src="' . $productRow["image"] . '" alt="' . $productRow["name"] . '" style="max-width: 200px;">';
                echo '<p>Description: ' . $productRow["description"] . '</p>';
                echo '<p>Price: $' . $productRow["price"] . '</p>';
                echo '<form action="product_catalog.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $productRow["id"] . '">';
                echo '<input type="hidden" name="name" value="' . $productRow["name"] . '">';
                echo '<input type="hidden" name="image" value="' . $productRow["image"] . '">';
                echo '<input type="hidden" name="price" value="' . $productRow["price"] . '">';
                echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }

        // Check if the form has been submitted
        if (isset($_POST['add_to_cart'])) {
            // Connect to the "kitten_cart" database
            $cartServername = "localhost";
            $cartUsername = "root";
            $cartPassword = "root";
            $cartDatabase = "project";

            $cartConn = new mysqli($cartServername, $cartUsername, $cartPassword, $cartDatabase);
            if ($cartConn->connect_error) {
                die("Connection to kitten_cart database failed: " . $cartConn->connect_error);
            }

            $productId = $_POST['product_id'];
            $name = $_POST['name'];
            $image = $_POST['image'];
            $price = $_POST['price'];

            // Insert product into cart database
            $stmt = $cartConn->prepare("INSERT INTO cart (product_id, name, image, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $productId, $name, $image, $price);
            $stmt->execute();

            // Close the connection to kitten_cart database
            $cartConn->close();
        }

        // Close the connection to project database
        $productConn->close();
        ?>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
