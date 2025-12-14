<?php
include "../db.php";

$stmt = mysqli_prepare($conn, "SELECT customer_id, name FROM customer ORDER BY customer_id DESC LIMIT 1");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $lastId, $lastName);
mysqli_stmt_fetch($stmt);

if (!$lastId) {
    echo '<div style="padding:15px;background:#fff3cd;color:#856404;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            No account found to delete
          </div>';
    exit;
}

$deleteStmt = mysqli_prepare($conn, "DELETE FROM customer WHERE customer_id = ?");
mysqli_stmt_bind_param($deleteStmt, "i", $lastId);

if (mysqli_stmt_execute($deleteStmt)) {
    echo '<div style="padding:15px;background:#e8f5e9;color:#2e7d32;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Account deleted successfully ('.$lastName.')
          </div>';
} else {
    echo '<div style="padding:15px;background:#ffebee;color:#c62828;border-radius:10px;text-align:center;width:fit-content;margin:50px auto;font-family:Arial;">
            Error while deleting account
          </div>';
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($deleteStmt);
mysqli_close($conn);
?>
