<?php
include "../db.php";

// Function to show messages
function showMessage($type, $text){
    echo '<div class="message '.$type.'">'.$text.'</div>';
}

// Check required fields
if(!isset($_POST['Name'], $_POST['Email'], $_POST['Phone'], $_POST['NewPassword'])){
    showMessage('error','❌ Please fill in all fields');
    exit;
}

$name = trim($_POST['Name']);
$email = trim($_POST['Email']);
$phone = trim($_POST['Phone']);
$newPassword = $_POST['NewPassword'];

if($name == "" || $email == "" || $phone == "" || $newPassword == ""){
    showMessage('error','❌ Please fill in all fields');
    exit;
}

// Verify user exists
$stmt = mysqli_prepare($conn, "SELECT customer_id FROM customer WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) == 0){
    showMessage('error','❌ Incorrect information, please try again');
    exit;
}

// Update password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateStmt = mysqli_prepare($conn, "UPDATE customer SET password=? WHERE name=? AND email=? AND phone=?");
mysqli_stmt_bind_param($updateStmt, "ssss", $hashedPassword, $name, $email, $phone);

if(mysqli_stmt_execute($updateStmt)){
    showMessage('success','✅ Password changed successfully!');
}else{
    showMessage('error','❌ Error occurred, please try again');
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>

<style>
/* Inputs */
input[type="text"], input[type="email"], input[type="password"] {
    width: 100%;
    max-width: 400px;
    padding: 12px 15px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1em;
    display: block;
    box-sizing: border-box;
}

/* Messages Styling */
.message {
    max-width: 500px;
    margin: 30px auto;
    padding: 15px 20px;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    position: relative;
}

.message.success {
    background: linear-gradient(45deg, #2af598, #009efd);
    color: #fff;
}

.message.error {
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    color: #fff;
}

.message::before {
    margin-right: 8px;
}

.message:hover {
    transform: translateY(-2px);
    transition: 0.3s ease;
}
</style>