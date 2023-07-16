<?php
// Start the session
session_start();

// Check if an employee is not logged in
if (!isset($_SESSION["employee_id"])) {
    // Redirect to the employee login page or any other desired location
    header("Location: employee_login.php");
    exit();
}

// Connect to the "project" database
$servername = "localhost:8889";
$username = "root";
$password = "root";
$database = "Project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle logout
if (isset($_POST["logout"])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the employee login page
    header("Location: employee_login.php");
    exit();
}
?><!DOCTYPE html>
<html>
<head>
    <title>Employee Product Edit Records</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the employee_product_edit_records page */
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
        
        .product-record {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #666666;
            border-radius: 5px;
        }
        
        .product-record h4 {
            margin: 0;
            color: #000000;
        }
        
        .product-record p {
            margin: 5px 0;
            color: #cccccc;
        }
        
        .delete-button {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #ff7f7f;
            color: #ffffff;
            text-decoration: none;
            margin-top: 10px;
        }
        
        .delete-button:hover {
            background-color: #e66969;
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
        <h2>Employee Product Edit Records</h2>

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

        // Check if the form is submitted for deleting a product record
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $recordId = $_POST["record_id"];

            // Delete the product record from the database
            $deleteSql = "DELETE FROM product_records WHERE product_record_id = $recordId";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult === TRUE) {
                // Refresh the page
                echo '<meta http-equiv="refresh" content="0">';
            } else {
                echo '<p>Error deleting product record: ' . $conn->error . '</p>';
            }
        }

        // Retrieve product edit records and employee information from the database
        $sql = "SELECT pr.product_record_id, pr.product_id, p.name AS product_name, pr.employee_id, e.name AS employee_name
                FROM product_records pr
                JOIN products p ON pr.product_id = p.id
                JOIN employee_info e ON pr.employee_id = e.id
                ORDER BY pr.employee_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $currentEmployeeId = null;
            while ($row = $result->fetch_assoc()) {
                $productRecordId = $row["product_record_id"];
                $productId = $row["product_id"];
                $productName = $row["product_name"];
                $employeeId = $row["employee_id"];
                $employeeName = $row["employee_name"];

                if ($currentEmployeeId !== $employeeId) {
                    if ($currentEmployeeId !== null) {
                        echo '</div>';
                    }

                    echo '<div class="employee">';
                    echo '<h4><span style="color: black;">' . $employeeName . '</span></h4>';
                }

                echo '<div class="product-record">';
                echo '<p>Product Record ID: ' . $productRecordId . '</p>';
                echo '<p>Product ID: ' . $productId . '</p>';
                echo '<p>Product Name: ' . $productName . '</p>';
                echo '<form action="' . $_SERVER["PHP_SELF"] . '" method="POST">';
                echo '<input type="hidden" name="record_id" value="' . $productRecordId . '">';
                echo '<button type="submit" class="delete-button">Delete</button>';
                echo '</form>';
                echo '</div>';

                $currentEmployeeId = $employeeId;
            }

            echo '</div>';
        } else {
            echo '<p>No product edit records found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
