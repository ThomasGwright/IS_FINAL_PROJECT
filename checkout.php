<?php
// Start the session
session_start();

// Check if the customer is not logged in
if (!isset($_SESSION["customer_id"])) {
    // Redirect to the login page or any other desired location
    header("Location: customer_login.php");
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

// Retrieve customer information from customer_info table
$customerName = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : '';
$customerAddress = isset($_SESSION['customer_address']) ? $_SESSION['customer_address'] : '';

if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    $query = "SELECT name, address FROM customer_info WHERE id = $customerId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customerName = $row['name'];
        $customerAddress = $row['address'];
    }
}


// Retrieve cart items and quantities from the cart table
$sql = "SELECT product_id, name, image, price, COUNT(*) AS quantity FROM cart GROUP BY product_id, name, image, price";
$result = $conn->query($sql);

if (!$result) {
    echo "Error retrieving cart items: " . $conn->error;
    exit();
}

// Calculate the total cost
$totalCost = 0;
while ($row = $result->fetch_assoc()) {
    $itemCost = $row["price"] * $row["quantity"];
    $totalCost += $itemCost;
}

if(isset($_POST['name'])){
// Insert the order details into the sales_report table
// Insert the order details into the sales_report table
$insertSql = "INSERT INTO sales_report (customer_id, customer_name, cart_total) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insertSql);
$stmt->bind_param("iss", $customerId, $customerName, $totalCost);

if ($stmt->execute()) {
    $orderId = $stmt->insert_id;
    echo "Order placed successfully. Order ID: " . $orderId;
} else {
    echo "Error placing the order: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Clear the cart by deleting all items
$clearCartSql = "DELETE FROM cart";
$conn->query($clearCartSql);
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kitten Factory - Checkout</title>
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
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container form label {
            margin-bottom: 10px;
        }

        .container form input[type="text"],
        .container form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .container form input[type="radio"] {
            margin-right: 5px;
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

        .container input[type="submit"] {
            width: 150px;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
            if (isset($_SESSION["customer_id"])) {
                // If logged in, display the logout button and customer's name
                echo '<form action="logout.php" method="POST">';
                echo '<button type="submit" name="logout" class="button">Logout</button>';
                echo '</form>';
                echo '<span>Welcome ' . $_SESSION["customer_name"] . '</span>';
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
        <h2>Checkout</h2>
        <form action="checkout.php" method="POST">
            <h3>Shipping Details</h3>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $customerName; ?>" required>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo $customerAddress; ?></textarea>
            
            <h3>Payment Method</h3>
            <input type="radio" id="credit-card" name="payment-method" value="credit-card" required>
            <label for="credit-card">Credit Card</label>
            <input type="radio" id="paypal" name="payment-method" value="paypal" required>
            <label for="paypal">PayPal</label>

            <h3>Order Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display order items dynamically
                    $result->data_seek(0); // Reset the result set pointer
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>$' . $row['price'] . '</td>';
                        echo '<td>$' . ($row['price'] * $row['quantity']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total:</td>
                        <td>$<?php echo $totalCost; ?></td>
                    </tr>
                </tfoot>
            </table>
            <input type="submit" value="Place Order">
        </form>
    </div>

    <div class="logo-container">
        <img src="logo.jpg" alt="Logo" class="logo">
    </div>
</body>
</html>
