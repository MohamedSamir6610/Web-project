<?php
include "../db.php";

if(!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])){
    echo '<div class="error">❌ يرجى ملء جميع الحقول</div>';
    exit;
}

$name = trim($_POST['Name']);
$email = trim($_POST['Email']);
$phone = trim($_POST['Phone']);
$newPassword = $_POST['NewPassword'];

if($name == "" || $email == "" || $phone == "" || $newPassword == ""){
    echo '<div class="error">❌ يرجى ملء جميع الحقول</div>';
    exit;
}

// التحقق من البيانات في الداتا بيز
$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) == 0){
    echo '<div class="error">❌ البيانات غير صحيحة، يرجى المحاولة</div>';
    exit;
}

// تحديث الباسورد
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateStmt = mysqli_prepare($conn, "UPDATE customer SET password=? WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($updateStmt, "ssss", $hashedPassword, $name, $email, $phone);

if(mysqli_stmt_execute($updateStmt)){
    echo '<div class="success">✅ تم تغيير الباسورد بنجاح!</div>';
}else{
    echo '<div class="error">❌ حدث خطأ، حاول مرة أخرى</div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>