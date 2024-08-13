<?php

session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    echo $gender;

    $sql = "INSERT INTO users (username, gender , password, email) VALUES ('$username','$gender','$password', '$email')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $username;
        header("location: home.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <h1>E-Sell</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>
<h2>Register</h2>
<form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="" disabled selected>Select your gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>
    
    <input type="submit" value="Register">
</form>

</body>
</html>
