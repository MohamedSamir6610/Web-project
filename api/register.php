<?php
include "../db.php";

if (!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])) {
    die("Form data not sent");
}

$name     = trim($_POST['Name']);
$email    = trim($_POST['Email']);
$phone    = trim($_POST['Phone']);
$password = $_POST['NewPassword'];

if ($name == "" || $email == "" || $password == "") {
    echo "❌The information is incomplete. Please fill in all the fields.";
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "⚠️This email address is already registered. Please sign in or recover your password.";
    exit;
}
mysqli_stmt_close($stmt);


$stmt = mysqli_prepare($conn, "INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo "✅Your account has been created successfully. Welcome! <strong>$name</strong> 🎉";
} else {
    echo "❌Error: Unable to register at this time. Please try again.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>