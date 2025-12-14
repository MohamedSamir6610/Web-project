<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wep-project1";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("DB Connection Error: " . mysqli_connect_error());
}
?>