<?php
include "../db.php";

// Get the last account
$stmt = mysqli_prepare($conn, "SELECT customer_id, name FROM customer ORDER BY customer_id DESC LIMIT 1");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $lastId, $lastName);
mysqli_stmt_fetch($stmt);

if(!$lastId){
    echo '<div class="message error">❌ No account to delete</div>';
    exit;
}

// Delete the account
$deleteStmt = mysqli_prepare($conn, "DELETE FROM customer WHERE customer_id = ?");
mysqli_stmt_bind_param($deleteStmt, "i", $lastId);

if(mysqli_stmt_execute($deleteStmt)){
    echo '<div class="message success">✅ Last account deleted successfully! ('.$lastName.')</div>';
}else{
    echo '<div class="message error">❌ Error occurred while deleting the account</div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($deleteStmt);
mysqli_close($conn);
?>

<style>
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