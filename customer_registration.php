 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo '<p>Passwords do not match.</p>';
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Connect to the "project" database
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "project";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the customer information into the database
        $stmt = $conn->prepare("INSERT INTO customer_info (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashedPassword);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            // Start the session
            session_start();
            $_SESSION["customer_id"] = $stmt->insert_id;
            $_SESSION["customer_name"] = $name;

            // Redirect to the customer login success page after successful registration
            echo '<script>window.location.href = "customer_registration_success.php";</script>';
            exit();
        } else {
            echo '<p>Error registering customer: ' . $conn->error . '</p>';
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration</title>
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

        .registration-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="tel"],
        .registration-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .registration-form button[type="submit"] {
            width: 100%;
            padding: 10px;
        }

        .employee-link-container {
            margin-top: 20px;
        }

        .employee-link {
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
            <a href="customer_login.php" class="button">Login</a>
            <a href="customer_registration.php" class="button">Register</a>
            <a href="cart.php" class="button">Cart</a>
        </div>
    </header>

    <div class="container">
        <h2>Customer Registration</h2>

        <form class="registration-form" action="customer_registration.php" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        
        <div class="employee-link-container">
            <a href="employee_registration.php" class="employee-link">Register New Employee</a>
        </div>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
