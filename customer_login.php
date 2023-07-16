<?php
// Start the session
session_start();

// Database connection
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch user information based on email
    $stmt = $conn->prepare("SELECT * FROM customer_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set the customer ID in the session
            $_SESSION["customer_id"] = $row["id"];

            // Redirect to the customer login success page
            header("Location: customer_login_success.php");
            exit();
        } else {
            // Login failed
            $login_error = "Invalid email or password. Please try again.";
        }
    } else {
        // Login failed
        $login_error = "Invalid email or password. Please try again.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

// Handle logout request
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the home page or any other desired location
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
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

        .container .login-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .container .login-form input[type="email"],
        .container .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .container .login-form button[type="submit"] {
            width: 100%;
            padding: 10px;
        }

        .container .error-message {
            color: red;
            margin-top: 10px;
        }

        .container .employee-login {
            margin-top: 20px;
        }

        .container .employee-login a {
            display: inline-block;
            background-color: #FF0000;
            color: #FFF;
            padding: 10px 20px;
            text-decoration: none;
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
            <?php if (isset($_SESSION["customer_id"])) { ?>
                <span>Welcome <?php echo $_SESSION["customer_name"]; ?></span>
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
        <h2>Customer Login</h2>

        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <br><br>
            <input type="password" name="password" placeholder="Password" required>
            <br><br>
            <button type="submit">Login</button>
        </form>

        <?php if (isset($login_error)) { ?>
            <p class="error-message"><?php echo $login_error; ?></p>
        <?php } ?>

        <div class="employee-login">
            Employee Login Here: <a href="employee_login.php" class="button">Employee Login</a>
        </div>
    </div>
</body>
</html>
