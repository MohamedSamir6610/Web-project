<?php
include '../db.php';
session_start();

// لو الموظف مش مسجل دخول
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

// جلب المنتجات من قاعدة البيانات
$products  = $conn->query("SELECT * FROM product");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // إضافة طلب عميل
    if(isset($_POST['place_order'])){
        $customer_name = $_POST['customer_name'];
        $product_id    = $_POST['product_id'];
        $quantity      = $_POST['quantity'];

        // حفظ الطلب في جدول orders و includes
        $conn->query("
            INSERT INTO orders (customer_name, order_date)
            VALUES ('$customer_name', NOW())
        ");

        $order_id = $conn->insert_id;

        $conn->query("
            INSERT INTO includes (order_id, product_id, quantity)
            VALUES ('$order_id', '$product_id', '$quantity')
        ");

        $message = "Order placed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Panel</title>
<link rel="stylesheet" href="employee.css">
</head>
<body>
<div class="container">
<h1>Employee Panel</h1>

<form method="POST" style="text-align:right;">
    <button type="submit" formaction="logout.php">Logout</button>
</form>

<h2>Place a New Order</h2>
<?php if(isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

<form method="POST" class="order-form">
    <input type="text" name="customer_name" placeholder="Customer Name" required>

    <select name="product_id" required>
        <option value="">Select Product</option>
        <?php while($p = $products->fetch_assoc()): ?>
            <option value="<?php echo $p['id']; ?>">
                <?php echo $p['name'] . " - $" . $p['price']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="quantity" placeholder="Quantity" min="1" value="1" required>
    <button type="submit" name="place_order">Place Order</button>
</form>

</div>
</body>
</html>
