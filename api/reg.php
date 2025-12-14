<?php
include "db.php";

// تحقق من وصول البيانات
if (!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])) {
    die("Form data not sent");
}

$name = $_POST['Name'];
$email = $_POST['Email'];
$phone = $_POST['Phone'];
$password = $_POST['NewPassword'];

if (empty($name) || empty($email) || empty($password)) {
    echo "empty";
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// تحقق من تكرار البريد
$result = mysqli_query($conn, "SELECT * FROM Customer WHERE email='$email'");
if ($result === false) {
    die("Query Failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    echo "exists";
    exit;
}

// إدخال البيانات
$sql_insert = "INSERT INTO Customer (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
if (mysqli_query($conn, $sql_insert)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>