<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Registration Successful</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the registration success page */
        body {
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .success-container h2 {
            margin-bottom: 20px;
        }

        .success-container .shopping-button {
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #44a17e;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h2>Registration Successful!</h2>
        <p>Thank you for registering with Kitten Factory.</p>
        <p>Click the button below to start shopping:</p>
        <a href="product_catalog.php" class="shopping-button">Take Me Shopping</a>
    </div>
</body>
</html>
