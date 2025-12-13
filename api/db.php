<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wep-project1"; // خلي الاسم ده زي ما عملت في MySQL

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("DB Connection Error");
}
?>