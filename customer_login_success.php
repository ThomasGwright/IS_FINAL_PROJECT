<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Customer Login Success</title>
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

        .logged-in-buttons {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .logged-in-buttons button {
            margin: 0 5px;
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
            // Start the session
            session_start();

            if (isset($_SESSION["customer_id"])) {
                // If logged in, display the welcome message and logout button
                echo '<span>Welcome ' . $_SESSION["customer_name"] . '</span>';
                echo '<form action="logout.php" method="POST" class="logged-in-buttons">';
                echo '<button type="submit" name="logout" class="button">Logout</button>';
                echo '</form>';
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
        <?php if (isset($_SESSION["customer_id"])) { ?>
            <span>Welcome <?php echo $_SESSION["customer_name"]; ?></span>
            <p>You are now logged in to the Kitten Factory website.</p>
            <p>Click the button below to start shopping:</p>
            <a href="product_catalog.php" class="shopping-button">Take Me Shopping</a>
        <?php } else { ?>
            <p>You are not logged in. Please <a href="customer_login.php">login</a> or <a href="customer_registration.php">register</a> to access this page.</p>
        <?php } ?>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
