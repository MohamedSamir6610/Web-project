<?php
include "../db.php";

/* التأكد إن البيانات وصلت */
if (
    !isset($_POST['Name']) ||
    !isset($_POST['Email']) ||
    !isset($_POST['Phone']) ||
    !isset($_POST['NewPassword'])
) {
    die("Form data not sent");
}

$name     = trim($_POST['Name']);
$email    = trim($_POST['Email']);
$phone    = trim($_POST['Phone']);
$password = $_POST['NewPassword'];

if ($name == "" || $email == "" || $password == "") {
    echo "empty";
    exit;
}

/* تشفير الباسورد */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

/* التأكد إن الإيميل مش موجود */
$stmt = mysqli_prepare(
    $conn,
    "SELECT customer_id FROM Customer WHERE email = ?"
);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "exists";
    exit;
}

mysqli_stmt_close($stmt);

/* إدخال البيانات */
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO Customer (name, email, phone, password)
     VALUES (?, ?, ?, ?)"
);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $name,
    $email,
    $phone,
    $hashed_password
);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>