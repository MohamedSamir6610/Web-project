<?php
include "../db.php";

if (!isset($_POST['Email'], $_POST['Password'])) {
    die("Form data not sent");
}

$email = trim($_POST['Email']);
$password = $_POST['Password'];

if ($email == "" || $password == "") {
    echo"

        ⚠️ Please enter your email and password.";
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
    echo "
    
        ❌ This email is not registered. Please sign up first.";
    exit;
}

mysqli_stmt_bind_result($stmt, $hashed_password, $name);
mysqli_stmt_fetch($stmt);

if (password_verify($password, $hashed_password)) {
    echo "

        ✅ Login successful!
        Welcome back,'.$name.' 🎉";
        exit;
} else {
    echo "
 
        ❌ Incorrect password. Please try again.";
        exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
