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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee Info</title>
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

        .employee-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: -10px;
        }

        .employee {
            width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            background-color: #E6F0E9;
            color: #306351;
        }

        .employee-buttons {
            display: flex;
            justify-content: space-between;
        }

        .add-employee-box {
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
        <h2>Edit Employee Info</h2>

        <?php
        // Retrieve employee information from the database
        $sql = "SELECT * FROM employee_info";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<div class="employee-container">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="employee">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<p>Email: ' . $row["email"] . '</p>';
                
                echo '<div class="employee-buttons">';
                echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                echo '<input type="hidden" name="employee_id" value="' . $row["id"] . '">';
                echo '<button type="submit" name="delete">Delete</button>';
                echo '</form>';
                echo '</div>';

                echo '</div>';
            }
            echo '</div>';

            echo '<div class="add-employee-box">';
            echo '<a href="employee_registration.php">Add New Employee</a>';
            echo '</div>';

            if (isset($_POST["delete_success"])) {
                echo '<div class="delete-success-box">';
                echo 'Employee deleted successfully.';
                echo '</div>';
            }
        } else {
            echo '<p>No employee information found.</p>';
        }

        // Handle delete request
        if (isset($_POST["delete"])) {
            $employeeId = $_POST["employee_id"];
            // Perform the delete operation based on the employee ID
            $deleteSql = "DELETE FROM employee_info WHERE id = $employeeId";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult === TRUE) {
                echo '<script>window.location.href = "edit_employee_info.php?delete_success=1";</script>';
                exit();
            } else {
                echo '<p>Error deleting employee: ' . $conn->error . '</p>';
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
