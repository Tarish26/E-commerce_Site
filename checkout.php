<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce"; // Change this to your actual database name

$con = mysqli_connect($host, $username, $password, $database);

// Check the database connection
if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Retrieve products in the user's cart along with quantities
$sql_cart = "SELECT `product`.*, `cart`.`quantity` FROM `cart` INNER JOIN `product` ON `cart`.`product_id` = `product`.`Sno.` WHERE `cart`.`user_id` = '$user_id'";
$result_cart = mysqli_query($con, $sql_cart);

// Check the result of the cart query
if (!$result_cart) {
    echo "Error: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file here -->
</head>
<body>

    <h1>Checkout</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;

            // Display cart items in the table
            while ($cartItem = mysqli_fetch_assoc($result_cart)) {
                $productTotal = $cartItem['product_price'] * $cartItem['quantity'];
                $totalAmount += $productTotal;

                echo "<tr>
                        <td>{$cartItem['product_name']}</td>
                        <td>{$cartItem['product_price']}</td>
                        <td>{$cartItem['quantity']}</td>
                        <td>{$productTotal}</td>
                    </tr>";
            }

            // Free the result set
            mysqli_free_result($result_cart);
            ?>

            <tr>
                <td colspan="3">Total Amount:</td>
                <td><?php echo $totalAmount; ?></td>
            </tr>
        </tbody>
    </table>

    <h2>Shipping Address</h2>
    <form action="site1.php" method="post">
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea>

        <input type="hidden" name="totalAmount" value="<?php echo $totalAmount; ?>">
        <input type="submit" name="submitOrder" value="Place Order">
    </form>

    <?php
    mysqli_close($con);
    ?>

</body>
</html>
