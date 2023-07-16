<?php
// Start the session
session_start();

// Check if an employee or customer is logged in
$loggedInEmployee = isset($_SESSION["employee_id"]) && isset($_SESSION["employee_name"]);
$loggedInCustomer = isset($_SESSION["customer_id"]) && isset($_SESSION["customer_name"]);

// Get the logged-in user's name
$loggedInUserName = "";
if ($loggedInEmployee) {
    $loggedInUserName = $_SESSION["employee_name"];
} elseif ($loggedInCustomer) {
    $loggedInUserName = $_SESSION["customer_name"];
}

// Handle logout
if (isset($_POST["logout"])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: employee_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Employee Login Success</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Global styles */
        body {
            background-color: #333333;
        }

        .container {
            margin: 0 auto;
            max-width: 800px;
        }

        /* Styles for the buttons */
        .left-buttons {
            float: left;
            border-radius: 5px;
            background-color: #44a17e;
            margin-right: 10px;
        }

        .left-buttons a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
        }

        .right-buttons {
            float: right;
            border-radius: 5px;
            background-color: #ff7f7f;
            margin-left: 10px;
        }

        .right-buttons a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
        }

        /* Common header styles */
        header {
            background-color: #f2f2f2;
            padding: 10px;
            overflow: auto;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-buttons,
        .right-buttons {
            display: flex;
            align-items: center;
        }

        /* Common logo styles */
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

        /* Additional styles for the employee login success page */
        .container {
            text-align: center;
            margin-top: 100px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .container p {
            margin-bottom: 10px;
        }

        .container .options {
            margin-top: 20px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #ff7f7f;
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }

        .logout-button:hover {
            background-color: #e66969;
        }
        
        .welcome-message {
            margin-bottom: 20px;
            color: #fff;
            font-size: 18px;
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <button type="submit" name="logout" class="logout-button">Logout</button>
            </form>
            <a href="customer_registration.php" class="button">Register</a>
            <a href="cart.php" class="button">Cart</a>
        </div>
    </header>

    <div class="container">
        <?php if ($loggedInEmployee || $loggedInCustomer) { ?>
<p class="welcome-message" style="color: black;">Welcome, <?php echo $loggedInUserName; ?>!</p>
        <?php } ?>
        <h2>Employee Login Successful</h2>
        <p>You have successfully logged in.</p>
        <p>What would you like to do?</p>
        <div class="options">
            <a href="product_edit.php" class="button">Edit Products</a>
            <a href="product_catalog.php" class="button">Browse the Site</a>
            <a href="edit_customer_info.php" class="button">Edit Customer Info</a>
            <a href="edit_employee_info.php" class="button">Edit Employee Info</a>
            <a href="Sales_report.php" class="button">View Sales Report</a>
               <a href="employee_product_edit_records.php" class="button">View Product Edit records</a>
        </div>
    </div>
</body>
</html>
