<?php
include "../db.php";

if(!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])){
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Please fill in all fields
          </div>';
    exit;
}

$name = trim($_POST['Name']);
$email = trim($_POST['Email']);
$phone = trim($_POST['Phone']);
$newPassword = $_POST['NewPassword'];

$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) == 0){
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Incorrect information. Please try again.
          </div>';
    exit;
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateStmt = mysqli_prepare($conn, "UPDATE customer SET password=? WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($updateStmt, "ssss", $hashedPassword, $name, $email, $phone);

if(mysqli_stmt_execute($updateStmt)){
    echo '<div style="padding:15px;background:#e8f5e9;color:#2e7d32;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Password updated successfully
          </div>';
}else{
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Error updating password
          </div>';
}

mysqli_close($conn);
?>
