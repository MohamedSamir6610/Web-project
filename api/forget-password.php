<?php
include "../db.php";

if(!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])){
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
        ❌ Please fill in all required fields.
    </div>';
    exit;
}

$name = trim($_POST['Name']);
$email = trim($_POST['Email']);
$phone = trim($_POST['Phone']);
$newPassword = $_POST['NewPassword'];

if($name == "" || $email == "" || $phone == "" || $newPassword == ""){
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
        ❌ Please fill in all required fields.
    </div>';
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) == 0){
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
        ❌ Incorrect information. Please try again.
    </div>';
    exit;
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateStmt = mysqli_prepare($conn, "UPDATE customer SET password=? WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($updateStmt, "ssss", $hashedPassword, $name, $email, $phone);

if(mysqli_stmt_execute($updateStmt)){
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
        ✅ Your password has been changed successfully!
    </div>';
}else{
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
        ❌ Something went wrong. Please try again.
    </div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>
