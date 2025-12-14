<?php
include "../db.php";

$stmt = mysqli_prepare($conn, "SELECT customer_id, name FROM customer ORDER BY customer_id DESC LIMIT 1");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $lastId, $lastName);
mysqli_stmt_fetch($stmt);

if(!$lastId){
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
        ❌ No account found to delete.
    </div>';
    exit;
}

$deleteStmt = mysqli_prepare($conn, "DELETE FROM customer WHERE customer_id = ?");
mysqli_stmt_bind_param($deleteStmt, "i", $lastId);

if(mysqli_stmt_execute($deleteStmt)){
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
        ✅ The last account has been deleted successfully.<br>
        <strong>'.$lastName.'</strong>
    </div>';
}else{
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
        ⚠️ An error occurred while deleting the account.
    </div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($deleteStmt);
mysqli_close($conn);
?>
