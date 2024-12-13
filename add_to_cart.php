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

// Check if the product_id is set in the POST request
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists in the database
    $sql_check_product = "SELECT * FROM `product` WHERE `Sno.` = $product_id";
    $result_check_product = mysqli_query($con, $sql_check_product);

    if ($result_check_product && mysqli_num_rows($result_check_product) > 0) {
        // Product exists, check if it is already in the user's cart
        $sql_check_cart = "SELECT * FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'";
        $result_check_cart = mysqli_query($con, $sql_check_cart);

        if ($result_check_cart && mysqli_num_rows($result_check_cart) > 0) {
            // Product is already in the cart, update the quantity
            $sql_update_quantity = "UPDATE `cart` SET `quantity` = `quantity` + 1 WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'";
            $result_update_quantity = mysqli_query($con, $sql_update_quantity);

            if (!$result_update_quantity) {
                echo "Error updating quantity: " . mysqli_error($con);
            } else {
                echo "Quantity updated successfully!";
                header("Location:site1.php");
                exit();
         
            }
        } else {
            // Product is not in the cart, add it with a quantity of 1
            $sql_add_to_cart = "INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES ('$user_id', '$product_id', 1)";
            $result_add_to_cart = mysqli_query($con, $sql_add_to_cart);

            if (!$result_add_to_cart) {
                echo "Error adding to cart: " . mysqli_error($con);
            } else {
                echo "Product added to cart successfully!";
                header("Location:site1.php");
                exit();
             
            }
        }
    } else {
        echo "Error: Product not found in the database.";
    }
} else {
    echo "Error: Invalid product ID.";
}

// Close the database connection
mysqli_close($con);
?>
