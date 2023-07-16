<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the index page */
        .container {
            text-align: center;
            margin-top: 100px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            margin-bottom: 20px;
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
        <h1>Welcome to Kitten Factory - Ski Manufacturing</h1>
        <p>Experience the thrill of customized carbon fiber skis!</p>
        <p>Our skis are designed for all terrains, offering a lighter weight and unmatched durability.</p>
        <p>Join our community of skiers and explore the park, powder, and backcountry with confidence.</p>
        <p>Start your adventure today!</p>
    </div>
<div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
