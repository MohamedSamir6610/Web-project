<?php
include "../db.php";

if (!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])) {
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Please complete all fields
          </div>';
    exit;
}

$name = trim($_POST['Name']);
$email = trim($_POST['Email']);
$phone = trim($_POST['Phone']);
$password = $_POST['NewPassword'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Email already exists. Please login or reset password.
          </div>';
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo '<div style="padding:15px;background:#e8f5e9;color:#2e7d32;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Registration successful! Welcome, <strong>'.$name.'</strong>
          </div>';
} else {
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Registration failed. Please try again.
          </div>';
}

mysqli_close($conn);
?>
