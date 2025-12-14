<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ecommerce_db";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("DB Connection Error: " . mysqli_connect_error());
}
?>