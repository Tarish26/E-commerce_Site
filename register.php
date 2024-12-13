<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce"; 

$nomatch=false;
$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection to database failed: " . mysqli_connect_error());
}

$insert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['passwrd'];

    // Check if password and passcode are the same
    if ($password == $_POST['password']) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        $sql = "INSERT INTO `customer` (`name`, `email`, `passwrd`) VALUES ('$name', '$email', '$hashedPassword')";

        if (mysqli_query($con, $sql)) {
            $insert = true;
            echo"Registered Successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        $nomatch=true;
    }
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
    <title>Registration Form</title>
</head>
<body>
    <div class="login">
        <img src="dark-texture-watercolor.jpg" alt="image" class="login__bg">
        <form action="register.php" method="post" class="login__form">

            <h1 class="login__title">Register</h1>

            <div class="login__inputs">

                <div class="login__box">
                   <input type="text" name="name"  placeholder="Full Name" required class="login__input">

                </div>

                <div class="login__box">
                    <input type="email" name="email" placeholder="Email" required class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>

                <div class="login__box">
                    <input type="password" name="passwrd" placeholder="Password" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>

                <div class="login__box">
                    <input type="password" name="password" placeholder="Confirm Password" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
                
            </div>
            <?php
             if($nomatch){
                echo'<div class="login__check">Password does not match<div>';
             }
            ?>
            <button type="submit" class="login__button">Register</button>
        </form>
    </div>

    <script src="index.js"></script>
</body>
</html>