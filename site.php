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

// Get user information from the database using the correct user identifier column
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `customer` WHERE `Sno.` = '$user_id'";
$result = mysqli_query($con, $sql);

// Check the result of the database query
if ($result) {
    $user = mysqli_fetch_assoc($result);

    // Check if user information is found
    if ($user) {
        $user_name = $user['name'];
        $user_email = $user['email'];
    } else {
        echo "Error: User not found in the database.";
        exit();
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
    exit();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="styles.css">
    <title>Site</title>
</head>
<body>
    <div class="site">
        <h1>Welcome to the Site</h1>
        
        <?php
        // Display the user's name
        echo '<p>Hello, ' . $user_name . '!</p>';
        echo'<p>Email:'. $user_email .'</p>';
        ?>

        <!-- Add the rest of your site content here -->

        <!-- Logout link -->
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
