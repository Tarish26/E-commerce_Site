<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
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

// Check if the user_id exists in the customer table
$sql_check_user = "SELECT COUNT(*) FROM `customer` WHERE `Sno.` = '$user_id'";
$result_check_user = mysqli_query($con, $sql_check_user);

if (!$result_check_user) {
    echo "Error checking user: " . mysqli_error($con);
    exit();
}

if (mysqli_fetch_row($result_check_user)[0] == 0) {
    echo "Error: User not found in the customer table.";
    exit();
}

// Proceed with the rest of your code...

// Your insert query for the checkout table
// Assuming you have these variables initialized somewhere in your code
// Replace these placeholder values with actual user input or dynamic data
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$address = $_POST['shipping_address'];
$total_amount = $productTotal;


$sql_insert_checkout = "INSERT INTO `checkout` (`user_id`, `product_id`, `quantity`, `address`, `total_amount`) VALUES ('$user_id', '$product_id', '$quantity', '$address', '$total_amount')";

$result_insert_checkout = mysqli_query($con, $sql_insert_checkout);

if ($result_insert_checkout) {
    echo "Order placed successfully!";
} else {
    echo "Error placing order: " . mysqli_error($con);
}

mysqli_close($con);
?>
