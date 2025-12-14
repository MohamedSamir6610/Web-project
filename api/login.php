<?php
include "../db.php";

// التأكد من وصول البيانات
if (!isset($_POST['Email'], $_POST['Password'])) {
    die("Form data not sent");
}

$email = trim($_POST['Email']);
$password = $_POST['Password'];

// التأكد من البيانات مش فاضية
if ($email == "" || $password == "") {
    echo "⚠️ هناك خطأ، يجب أن تقوم بالتسجيل أو فورمات الباسورد";
    exit;
}

// جلب الباسورد والاسم من الجدول بطريقة صحيحة
$stmt = mysqli_prepare($conn, "SELECT password, name FROM customer WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 0) {
    // الإيميل مش موجود
    echo "⚠️ هناك خطأ، يجب أن تقوم بالتسجيل أو فورمات الباسورد";
    exit;
}

// ربط النتائج
mysqli_stmt_bind_result($stmt, $hashed_password, $name);
mysqli_stmt_fetch($stmt);

// التحقق من الباسورد
if (password_verify($password, $hashed_password)) {
    echo "✅ تسجيل الدخول ناجح! أهلاً بك مرة أخرى، <strong>$name</strong> 🎉";
} else {
    echo "⚠️ هناك خطأ، يجب أن تقوم بالتسجيل أو فورمات الباسورد";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>