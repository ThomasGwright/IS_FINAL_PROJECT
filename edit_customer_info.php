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

    // Redirect to the customer login page
    header("Location: customer_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer Info</title>
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
            text-align: center;
        }

        .customer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: -10px;
        }

        .customer {
            width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            background-color: #E6F0E9;
            color: #306351;
        }

        .customer-buttons {
            display: flex;
            justify-content: space-between;
        }

        .add-customer-box {
            border: 1px solid #ccc;
            padding: 5px;
            margin-top: 20px;
            background-color: #E6F0E9;
            color: #306351;
            display: inline-block;
        }

        .delete-success-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            background-color: #FFCACA;
            color: #D8000C;
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
        <h2>Edit Customer Info</h2>

        <?php
        // Connect to the "project" database
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "project";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve customer information from the database
        $sql = "SELECT * FROM customer_info";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<div class="customer-container">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="customer">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<p>Email: ' . $row["email"] . '</p>';
                echo '<p>Phone: ' . $row["phone"] . '</p>';
                echo '<p>Address: ' . $row["address"] . '</p>';

                echo '<div class="customer-buttons">';
                echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                echo '<input type="hidden" name="customer_id" value="' . $row["id"] . '">';
                echo '<button type="submit" name="delete">Delete</button>';
                echo '</form>';
                echo '</div>';

                echo '</div>';
            }
            echo '</div>';

            echo '<div class="add-customer-box">';
            echo '<a href="customer_registration.php">Add New Customer</a>';
            echo '</div>';

            if (isset($_POST["delete_success"])) {
                echo '<div class="delete-success-box">';
                echo 'Customer deleted successfully.';
                echo '</div>';
            }
        } else {
            echo '<p>No customer information found.</p>';
        }

        // Handle delete request
        if (isset($_POST["delete"])) {
            $customerId = $_POST["customer_id"];
            // Perform the delete operation based on the customer ID
            $deleteSql = "DELETE FROM customer_info WHERE id = $customerId";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult === TRUE) {
                echo '<script>window.location.href = "edit_customer_info.php?delete_success=1";</script>';
                exit();
            } else {
                echo '<p>Error deleting customer: ' . $conn->error . '</p>';
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
