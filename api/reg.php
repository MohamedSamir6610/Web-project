<?php
include "db.php";

// استلام البيانات من الفورم
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($password)) {
    echo "empty";
    exit;
}

// تشفير الباسورد
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// التأكد من عدم تكرار البريد
$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    echo "exists";
    exit;
}

// إدخال البيانات
$query = "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$hashed_password')";
if (mysqli_query($conn, $query)) {
    echo "success";
} else {
    echo "error";
}
?>