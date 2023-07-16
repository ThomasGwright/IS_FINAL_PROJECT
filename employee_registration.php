<?php
// Start the session
session_start();

// Check if the employee is already logged in
if (isset($_SESSION["employee_id"])) {
    // If logged in, redirect to the employee login success page
    header("Location: employee_login_success.php");
    exit();
}

// Database connection
$servername = "localhost:8889";
$username = "root";
$password = "root";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $sql_check = "SELECT * FROM employee_info WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // If email already exists, display error message
        $registration_error = "An account with this email already exists. Please login or use a different email.";
    } else {
        // Create SQL query to insert user data into the table
        $sql_insert = "INSERT INTO employee_info (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

        // Execute the query
        if ($conn->query($sql_insert) === true) {
            // Store the employee ID in the session
            $_SESSION["employee_id"] = $conn->insert_id;
            $_SESSION["employee_name"] = $name;

            // Redirect to the registration success page
            header("Location: employee_login_success.php");
            exit();
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the employee registration page */
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

        .container .employee-registration {
            margin-top: 20px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
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
            <?php if (isset($_SESSION["employee_id"])) { ?>
                <span>Welcome <?php echo $_SESSION["employee_name"]; ?></span>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <button type="submit" name="logout" class="button">Logout</button>
                </form>
            <?php } else { ?>
                <a href="employee_login.php" class="button">Login</a>
                <a href="employee_registration.php" class="button">Register</a>
            <?php } ?>
            <a href="cart.php" class="button">Cart</a>
        </div>
    </header>

    <div class="container">
        <h2>Employee Registration</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Register" class="button">
        </form>
        <?php if (isset($registration_error)) { ?>
            <p class="error-message"><?php echo $registration_error; ?></p>
        <?php } ?>
    </div>
</body>
</html>
