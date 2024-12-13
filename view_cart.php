<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

// Establish a database connection
$con = mysqli_connect($host, $username, $password, $database);

// Check the database connection
if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

// Get user ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve products in the user's cart
$sql_cart = "SELECT `product`.*, `cart`.`quantity` FROM `cart` INNER JOIN `product` ON `cart`.`product_id` = `product`.`Sno.`WHERE `cart`.`user_id` = '$user_id'";
$result_cart = mysqli_query($con, $sql_cart);

// Check the result of the cart query
if (!$result_cart) {
    echo "Error: " . mysqli_error($con);
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <h1>Your Shopping Cart</h1>

    <?php
    // Display cart items
    while ($cartItem = mysqli_fetch_assoc($result_cart)) {
        echo "<div class='card'>
                <img src='{$cartItem['product_image']}' alt='Product Image'>
                <p>{$cartItem['product_name']} - Price: {$cartItem['product_price']}</p>
                <p>Quantity: {$cartItem['quantity']}</p>
              </div>";
    }

    // Free the result set
    mysqli_free_result($result_cart);
    ?>

    <a href="site1.php">Continue Shopping</a>

</body>
</html>
