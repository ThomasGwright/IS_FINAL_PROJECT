<?php
// Start the session
session_start();

// Check if the customer is not logged in
if (!isset($_SESSION["customer_id"])) {
    // Redirect to the login page or any other desired location
    header("Location: customer_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Cart</title>
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

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            text-align: center;
        }

        .container span {
            display: block;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .shopping-button {
            display: inline-block;
            background-color: green;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
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
                // If logged in, display the logout button and customer's name
                echo '<form action="logout.php" method="POST">';
                echo '<button type="submit" name="logout" class="button">Logout</button>';
                echo '</form>';
                echo '<span>Welcome ' . $_SESSION["customer_name"] . '</span>';
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
        <h2>Cart</h2>

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

        // Retrieve cart items and quantities from the cart table
        $sql = "SELECT product_id, name, image, price, COUNT(*) AS quantity FROM cart GROUP BY product_id, name, image, price";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $totalCost = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '" style="max-width: 200px;">';
                echo '<p>Price: $' . $row["price"] . '</p>';
                echo '<p>Quantity: ' . $row["quantity"] . '</p>';

                $itemCost = $row["price"] * $row["quantity"];
                $totalCost += $itemCost;
                echo '<p>Item Cost: $' . $itemCost . '</p>';

                echo '<form action="cart.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<button type="submit" name="delete">Remove from Cart</button>';
                echo '</form>';

                echo '<form action="product_catalog.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<input type="hidden" name="name" value="' . $row["name"] . '">';
                echo '<input type="hidden" name="image" value="' . $row["image"] . '">';
                echo '<input type="hidden" name="price" value="' . $row["price"] . '">';
                echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                echo '</form>';

                echo '</div>';
            }

            echo '<h3>Total Cost: $' . $totalCost . '</h3>';
            echo '<form action="checkout.php" method="POST">';
            echo '<input type="hidden" name="total_cost" value="' . $totalCost . '">';
            echo '<button type="submit">Checkout</button>';
            echo '</form>';
        } else {
            echo '<p>No items in the cart.</p>';
        }

        // Handle delete request
        if (isset($_POST["delete"])) {
            $productId = $_POST["product_id"];
            $deleteSql = "DELETE FROM cart WHERE product_id = $productId";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult === TRUE) {
                echo '<p>Item removed from cart successfully.</p>';
                // Refresh the page after deletion
                echo '<script>window.location.href = "cart.php";</script>';
            } else {
                echo '<p>Error removing item from cart: ' . $conn->error . '</p>';
            }
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
