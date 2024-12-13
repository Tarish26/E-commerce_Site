<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    // Check if the product is already in the cart
    $sql_check_cart = "SELECT * FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'";
$result_check_cart = mysqli_query($con, $sql_check_cart);

if (!$result_check_cart) {
    echo "Error checking the cart: " . mysqli_error($con);
    exit();
}

// Fetch the result as an associative array
$cartItem = mysqli_fetch_assoc($result_check_cart);

// Check if the product is in the cart and has a positive quantity
if ($cartItem && $cartItem['quantity'] > 0) {
    // If the product is in the cart, update the quantity
    $sql_update_quantity = "UPDATE `cart` SET `quantity` = `quantity` - 1 WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'";

    $result_update_quantity = mysqli_query($con, $sql_update_quantity);

    if (!$result_update_quantity) {
        echo "Error updating quantity in the cart: " . mysqli_error($con);
        exit();
    }
} else {
    // Remove the product from the cart
    $sql_remove = "DELETE FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'";
    $result_remove = mysqli_query($con, $sql_remove);

    if (!$result_remove) {
        echo "Error removing item from the cart: " . mysqli_error($con);
        exit();
    }
}

// Redirect back to the cart page
header("Location: site1.php");
exit();

}


mysqli_close($con);
?>
