<?php
include "../db.php";

if (!isset($_POST['Email'], $_POST['Password'])) {
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Form data not sent
          </div>';
    exit;
}

$email = trim($_POST['Email']);
$password = $_POST['Password'];

if ($email == "" || $password == "") {
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Please login or reset your password
          </div>';
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT password, name FROM customer WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 0) {
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Account not found. Please sign up or reset password.
          </div>';
    exit;
}

mysqli_stmt_bind_result($stmt, $hashed_password, $name);
mysqli_stmt_fetch($stmt);

if (password_verify($password, $hashed_password)) {
    echo '<div style="padding:15px;background:#e8f5e9;color:#2e7d32;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Login successful! Welcome back, <strong>'.$name.'</strong>
          </div>';
} else {
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Incorrect password. Please try again.
          </div>';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
