
<?php
$servername = "localhost";
$username = "danielz";
$password = "1234";
$dbname = "web2";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>