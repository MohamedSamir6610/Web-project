<?php
include "../db.php";

// التأكد من وصول البيانات
if (!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])) {
    die("Form data not sent");
}

$name     = trim($_POST['Name']);
$email    = trim($_POST['Email']);
$phone    = trim($_POST['Phone']);
$password = $_POST['NewPassword'];

// التحقق من البيانات مش فاضية
if ($name == "" || $email == "" || $password == "") {
    echo "❌ البيانات غير مكتملة، من فضلك أكمل جميع الحقول.";
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
    echo "⚠️ هذا الإيميل مستخدم من قبل، حاول تسجيل الدخول أو استعادة كلمة المرور.";
    exit;
}
mysqli_stmt_close($stmt);

// إدخال البيانات
$stmt = mysqli_prepare($conn, "INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo "✅ تم التسجيل بنجاح! أهلاً بك، <strong>$name</strong> 🎉";
} else {
    echo "❌ حدث خطأ أثناء التسجيل، حاول مرة أخرى.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>