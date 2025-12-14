<?php
include "../db.php";

// اختيار آخر account
$stmt = mysqli_prepare($conn, "SELECT customer_id, name FROM customer ORDER BY customer_id DESC LIMIT 1");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $lastId, $lastName);
mysqli_stmt_fetch($stmt);

if(!$lastId){
    echo '<div class="error">❌ لا يوجد حساب لحذفه</div>';
    exit;
}

// حذف الحساب
$deleteStmt = mysqli_prepare($conn, "DELETE FROM customer WHERE customer_id = ?");
mysqli_stmt_bind_param($deleteStmt, "i", $lastId);

if(mysqli_stmt_execute($deleteStmt)){
    echo '<div class="success">✅ تم حذف الحساب الأخير بنجاح! ('.$lastName.')</div>';
}else{
    echo '<div class="error">❌ حدث خطأ أثناء الحذف</div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($deleteStmt);
mysqli_close($conn);
?>