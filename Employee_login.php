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
$database = "Project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch user information based on email
    $stmt = $conn->prepare("SELECT * FROM employee_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if a matching user is found
    if ($result->num_rows === 1) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Verify the password
   		 if (password_verify($password, $row['password'])) {
            // Set the customer ID in the session
            $_SESSION["employee_id"] = $row["id"];

            // Redirect to the employee login success page
            header("Location: employee_login_success.php");
            exit();
        }
    }

    // Login failed
    $login_error = "Invalid email or password. Please try again.";

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styles for the employee login page */
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

        .container .employee-login {
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
                <a href="customer_login.php" class="button">Login</a>
                <a href="customer_registration.php" class="button">Register</a>
            <?php } ?>
            <a href="cart.php" class="button">Cart</a>
        </div>
    </header>

    <div class="container">
        <h2>Employee Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Login" class="button">
        </form>
        <?php if (isset($login_error)) { ?>
            <p class="error-message"><?php echo $login_error; ?></p>
        <?php } ?>
    </div>
</body>
</html>
