<?php
// Start the session
session_start();

// Check if the employee is not logged in
if (!isset($_SESSION["employee_id"])) {
    // Redirect to the login page or any other desired location
    header("Location: employee_login.php");
    exit();
}

// Connect to the "project" database
$servername = "localhost:8889";
$username = "root";
$password = "root";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a sale ID is provided for deletion
if (isset($_GET['delete'])) {
    $saleId = $_GET['delete'];

    // Delete the sale from the sales_report table
    $deleteSql = "DELETE FROM sales_report WHERE order_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $saleId);

    if ($stmt->execute()) {
        echo "Sale deleted successfully.";
    } else {
        echo "Error deleting the sale: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Retrieve sales from the sales_report table
$sql = "SELECT * FROM sales_report";
$result = $conn->query($sql);

if (!$result) {
    echo "Error retrieving sales: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
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
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .container table thead th {
            padding: 10px;
            border-bottom: 1px solid #000;
        }

        .container table tbody td {
            padding: 10px;
            border-bottom: 1px solid #000;
        }

        .container table tfoot td {
            padding: 10px;
            font-weight: bold;
        }

        .container table .actions {
            text-align: center;
        }

        .container table .actions a {
            color: red;
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
        // If an employee is logged in, display the logout button and employee's name
        echo '<form action="logout.php" method="POST">';
        echo '<button type="submit" name="logout" class="button">Logout</button>';
        echo '</form>';
        echo '<div class="welcome-box">';
        echo '<span>Welcome ' . $_SESSION["employee_name"] . '</span>';
        echo '</div>';
   
    } else {
        // If no one is logged in, display the login and register buttons
        echo '<a href="customer_login.php" class="button">Login</a>';
        echo '<a href="customer_registration.php" class="button">Register</a>';
    }
    ?>
    <a href="employee_login_success.php" class="button">Admin</a>
</div>

    </header>

    <div class="container">
        <h2>Sales Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Cart Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display sales dynamically
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['order_id'] . '</td>';
                    echo '<td>' . $row['customer_id'] . '</td>';
                    echo '<td>' . $row['customer_name'] . '</td>';
                    echo '<td>$' . $row['cart_total'] . '</td>';
                    echo '<td class="actions">';
                    echo '<a href="sales_report.php?delete=' . $row['order_id'] . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
