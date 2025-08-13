<?php
$host = "localhost";
$username = "root";
$password = ""; // Replace with your DB password if any
$database = "cbt";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
