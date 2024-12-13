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
$database = "ecommerce"; 

$con = mysqli_connect($host, $username, $password, $database);

// Check the database connection
if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

// Get user information from the database using the correct user identifier column
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM `customer` WHERE `Sno.` = '$user_id'";
$result_user = mysqli_query($con, $sql_user);

// Check the result of the user database query
if ($result_user) {
    $user = mysqli_fetch_assoc($result_user);

    // Check if user information is found
    if (!$user) {
        echo "Error: User not found in the database.";
        exit();
    }
} else {
    echo "Error: " . $sql_user . "<br>" . mysqli_error($con);
    exit();
}

$sql_product = "SELECT * FROM `product`";
$result_product = mysqli_query($con, $sql_product);

if (!$result_product) {
    echo "Error: " . mysqli_error($con);
    exit();
}

$cart = mysqli_num_rows($result_product) > 0; // Check if there are products in the cart
// Retrieve products in the user's cart
$sql_cart = "SELECT `product`.*, `cart`.`quantity` FROM `cart` INNER JOIN `product` ON `cart`.`product_id` = `product`.`Sno.`WHERE `cart`.`user_id` = '$user_id'";
$result_cart = mysqli_query($con, $sql_cart);

// Check the result of the cart query
if (!$result_cart) {
    echo "Error: " . mysqli_error($con);
    exit();
}


mysqli_close($con);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/313b5a5e74.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <!--NAVBAR MAIN-->
    <header class="navbar">
        <ul class="menu">
            <li class="logo"><img src="" alt="logo"></li>
            <li><button type="button" id="darkMode">Dark Mode</button></li>
            <li class="searchIcon"><i class="fas fa-search"></i></li>
            <li class="user"><a title="user" href="#"><i id="profileIcon" class="fa-solid fa-user"></i></a>
            <div id="profileDropdown">
                
                <span class="name">Name: <br><?php echo $user['name']?> </span>
                <span class="email">Email: <br><?php echo $user['email']?></span>
                <button class="logOut"><a href="logout.php"> Logout</a>
            
            </div></li>
            <li class="cart"><a title="cart" href="#"><i id="openCart" class="fa-solid fa-cart-shopping"></i></a>
        <div id="cartItems"> <h1>Your Shopping Cart</h1>

<?php
// Display cart items
while ($cartItem = mysqli_fetch_assoc($result_cart)) {
    echo "<div class='Item'>
            <img src='{$cartItem['product_image']}' alt='Product Image'>
            <p>{$cartItem['product_name']} - Price: {$cartItem['product_price']}</p>
            <p>Quantity: {$cartItem['quantity']}</p>
            <form method='post' action='remove_from_cart.php'>
                <input type='hidden' name='product_id' value='{$cartItem['Sno.']}'>
                <button type='submit' class='removeFromCart'>Remove from Cart</button>
            </form>
          </div>";
}
mysqli_free_result($result_cart);
?>

<a id="contShopping" href="checkout.php">Checkout</a></div></li>
        </ul>
    </header>

    <!--SEARCH EXTENTED-->
    <div class="navbar" id="navbar2">
     <form id="form" action="">
        <input type="text" id="input" placeholder="search">
        <button id="submit" type="button"><i id="searchIcon2" class="fas fa-search"></i></button>
     </form>
        <i class="fa-solid fa-xmark"></i>
    </div>

    <!--BANNER-->
    <div class="banner">
        <img src="banner.jpg" alt="">
    </div>
    <div class="hide-banner"></div>

    <!--FEATURED PRODUCTS-->
    <div class="container">
        <h2>Featured Products</h2>

        <div class="items">
          
    <?php
    if ($cart) {
        
       
        while ($product = mysqli_fetch_assoc($result_product)) {
            $product_id = $product['Sno.'];
            echo "<div class='card' id='product{$product_id}'>
                    <img src='{$product['product_image']}' alt='Product Image'>
                    <p class='desc'>{$product['product_name']} - Price: {$product['product_price']}</p>
                    <form method='post' action='add_to_cart.php'>
                        <input type='hidden' name='product_id' value='{$product['Sno.']}'>
                        <button type='submit' class='addCart'>Add to Cart</button>
                    </form>
                  </div>";
        }

    }
    ?>
        
        </div>
    </div>
<footer>
    <div class="aboutUs">
        <h3>About Us</h3><br>
        <p>We are best in the buisness</p>
    </div>
    <div class="separation">|</div>
    <div class="followUs">
        <h3>Follow Us</h3>
        <img src="" alt="insta">
        <img src="" alt="linkdn">
    </div>

 
</footer>

   
    <script src="script2.js"></script>
</body>
</html>