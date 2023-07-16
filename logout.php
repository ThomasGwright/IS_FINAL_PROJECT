<?php
// Start the session
session_start();

// Check if the session is active
if (isset($_SESSION["employee_id"]) || isset($_SESSION["customer_id"])) {
    // Clear the cart table in the project database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "project";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Clear the cart table
    $cartSql = "TRUNCATE TABLE cart";
    $conn->query($cartSql);

    // Close the connection
    $conn->close();
}

// Destroy the session and redirect to the login page
session_destroy();
header("Location: customer_login.php");
exit();
?>
