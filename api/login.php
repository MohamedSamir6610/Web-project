<?php
include "../db.php";

if (!isset($_POST['Email'], $_POST['Password'])) {
    die("Form data not sent");
}

$email = trim($_POST['Email']);
$password = $_POST['Password'];

if ($email == "" || $password == "") {
    echo '
    <div style="
        width: fit-content;
        margin: 120px auto;
        padding: 15px 25px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        border-radius: 10px;
        font-family: Arial;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    ">
        ⚠️ Please enter your email and password.
    </div>';
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT password, name FROM customer WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 0) {
    echo '
    <div style="
        width: fit-content;
        margin: 120px auto;
        padding: 15px 25px;
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        font-family: Arial;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    ">
        ❌ This email is not registered. Please sign up first.
    </div>';
    exit;
}

mysqli_stmt_bind_result($stmt, $hashed_password, $name);
mysqli_stmt_fetch($stmt);

if (password_verify($password, $hashed_password)) {
    echo '
    <div style="
        width: fit-content;
        margin: 120px auto;
        padding: 18px 30px;
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 12px;
        font-family: Arial;
        font-size: 18px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.18);
    ">
        ✅ Login successful!<br>
        Welcome back, <strong>'.$name.'</strong> 🎉
    </div>';
} else {
    echo '
    <div style="
        width: fit-content;
        margin: 120px auto;
        padding: 15px 25px;
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        font-family: Arial;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    ">
        ❌ Incorrect password. Please try again.
    </div>';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
