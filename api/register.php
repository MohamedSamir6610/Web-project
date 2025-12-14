<?php
include "../db.php";

// التأكد من وصول البيانات
if (!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])) {
    echo '
    <div style="
        margin:120px auto;
        width:fit-content;
        padding:16px 28px;
        background:#f8d7da;
        color:#721c24;
        border:1px solid #f5c6cb;
        border-radius:10px;
        font-family:Arial;
        font-size:16px;
        text-align:center;
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
    ">
        ❌ Form data was not sent correctly.
    </div>';
    exit;
}

$name     = trim($_POST['Name']);
$email    = trim($_POST['Email']);
$phone    = trim($_POST['Phone']);
$password = $_POST['NewPassword'];

// التحقق من البيانات مش فاضية
if ($name == "" || $email == "" || $password == "") {
    echo '
    <div style="
        margin:120px auto;
        width:fit-content;
        padding:16px 28px;
        background:#fff3cd;
        color:#856404;
        border:1px solid #ffeeba;
        border-radius:10px;
        font-family:Arial;
        font-size:16px;
        text-align:center;
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
    ">
        ⚠️ Please complete all required fields.
    </div>';
    exit;
}

// تشفير الباسورد
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// التأكد من أن الإيميل مش موجود
$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo '
    <div style="
        margin:120px auto;
        width:fit-content;
        padding:18px 30px;
        background:#f8d7da;
        color:#721c24;
        border:1px solid #f5c6cb;
        border-radius:12px;
        font-family:Arial;
        font-size:16px;
        text-align:center;
        box-shadow:0 10px 25px rgba(0,0,0,0.18);
    ">
        ⚠️ This email is already registered.<br>
        Please log in or reset your password.
    </div>';
    exit;
}
mysqli_stmt_close($stmt);

// إدخال البيانات
$stmt = mysqli_prepare($conn, "INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo '
    <div style="
        margin:120px auto;
        width:fit-content;
        padding:20px 34px;
        background:#d4edda;
        color:#155724;
        border:1px solid #c3e6cb;
        border-radius:14px;
        font-family:Arial;
        font-size:18px;
        text-align:center;
        box-shadow:0 12px 28px rgba(0,0,0,0.2);
    ">
        ✅ Registration successful!<br>
        Welcome, <strong>'.$name.'</strong> 🎉
    </div>';
} else {
    echo '
    <div style="
        margin:120px auto;
        width:fit-content;
        padding:16px 28px;
        background:#f8d7da;
        color:#721c24;
        border:1px solid #f5c6cb;
        border-radius:10px;
        font-family:Arial;
        font-size:16px;
        text-align:center;
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
    ">
        ❌ An error occurred while registering.<br>
        Please try again.
    </div>';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
