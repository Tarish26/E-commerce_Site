<?php
session_start(); // Start the session

$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce"; 

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection to the database failed: " . mysqli_connect_error());
}

// Initialize incorrect password status
$incorrectPassword = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM `customer` WHERE `email` = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if (password_verify($password, $row['passwrd'])) {
            // Password is correct, start the session and redirect to a secure page
            $_SESSION['user_id'] = $row['Sno.']; // Store user ID in the session
            header("Location: site1.php");
            exit();
        } else {
            // Set incorrect password status
            $incorrectPassword = true;
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

mysqli_close($con);
?>

<!-- HTML code (index.php) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="styles.css">
    <title>Login form</title>
</head>
<body>
    <div class="login">
        <img src="dark-texture-watercolor.jpg" alt="image" class="login__bg">

        <form action="index.php" method="post" class="login__form">
            <h1 class="login__title">Login</h1>

            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" name="email" placeholder="Email ID" required class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>

                <div class="login__box">
                    <input type="password" name="password" placeholder="Password" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
            </div>

            <?php
            // Display error message if the password is incorrect
            if ($incorrectPassword) {
                echo '<div class="login__check">Incorrect password</div>';
            }
            ?>

            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Remember me</label>
                </div>

                <a href="#" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button">Login</button>

            <div class="login__register">
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</body>
</html>
