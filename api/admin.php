<?php
include '../db.php';
session_start();



// حماية الصفحة: لو مش أدمن يتحول للصفحة الخاصة بالموظف
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: employee.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

   

   
    if(isset($_POST['add_customer'])){
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $password = $_POST['password'];

        $conn->query("
            INSERT INTO customer (name,email,phone,password)
            VALUES ('$name','$email','$phone','$password')
        ");
    }

    
    if(isset($_POST['edit_customer'])){
        $email = $_POST['email'];
        $name  = $_POST['name'];
        $phone = $_POST['phone'];

        $conn->query("
            UPDATE customer
            SET name='$name', phone='$phone'
            WHERE email='$email'
        ");
    }

    
    if(isset($_POST['delete_customer'])){
        $email = $_POST['email'];
        $conn->query("DELETE FROM customer WHERE email='$email'");
    }

    

   
    if(isset($_POST['add_product'])){
        $name  = $_POST['p_name'];
        $price = $_POST['p_price'];
        $desc  = $_POST['p_desc'];
        $image = $_POST['p_image']; 

        $conn->query("
            INSERT INTO product (name, price, description, image)
            VALUES ('$name','$price','$desc','$image')
        ");
    }

   
    if(isset($_POST['edit_product'])){
        $name_old = $_POST['p_old_name'];
        $name_new = $_POST['p_name'];
        $price    = $_POST['p_price'];
        $desc     = $_POST['p_desc'];
        $image    = $_POST['p_image'];

        $conn->query("
            UPDATE product
            SET name='$name_new', price='$price', description='$desc', image='$image'
            WHERE name='$name_old'
        ");
    }

   
    if(isset($_POST['delete_product'])){
        $name = $_POST['p_old_name'];
        $conn->query("DELETE FROM product WHERE name='$name'");
    }

    header("Location: admin.php");
    exit;
}



$customers = $conn->query("SELECT * FROM customer");
$products  = $conn->query("SELECT * FROM product");

$customer = $conn->query("SELECT * FROM customer");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="admin.css">
</head>

<body>
<div class="container">

<h1>Admin Panel</h1>

<form method="POST" style="text-align:right;">
    <button type="submit" class="logout" formaction="logout.php">Logout</button>
</form>



<h2>Customers</h2>

<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Password</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>

<?php while($row = $customers->fetch_assoc()): ?>
<tr>
<form method="POST">
    <td><input type="text" name="name" value="<?php echo $row['name']; ?>" required></td>
    <td><input type="email" name="email" value="<?php echo $row['email']; ?>" readonly></td>
    <td><input type="text" name="phone" value="<?php echo $row['phone']; ?>"></td>
    <td><input type="password" value="<?php echo $row['password']; ?>" readonly></td>

    <td>
        <button type="submit" name="edit_customer" class="edit">Edit</button>
    </td>
    <td>
        <button type="submit" name="delete_customer" class="delete"
        onclick="return confirm('Delete this customer?')">Delete</button>
    </td>
</form>
</tr>
<?php endwhile; ?>
</table>

<h3>Add New Customer</h3>
<form method="POST" class="add-customer">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="add_customer" class="edit">Add Customer</button>
</form>



<h2>Menu Products</h2>

<table>
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Description</th>
    <th>Image</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>
<tr>
<form method="POST">
    <td>
        <input type="text" name="p_name" value="<?php echo $p['name']; ?>" required>
        <input type="hidden" name="p_old_name" value="<?php echo $p['name']; ?>">
    </td>
    <td>
        <input type="number" step="0.01" name="p_price" value="<?php echo $p['price']; ?>" required>
    </td>
    <td>
        <input type="text" name="p_desc" value="<?php echo $p['description']; ?>">
    </td>
    <td>
        <input type="text" name="p_image" value="<?php echo $p['image']; ?>" placeholder="Image URL or filename">
    </td>

    <td>
        <button type="submit" name="edit_product" class="edit">Edit</button>
    </td>

    <td>
        <button type="submit" name="delete_product" class="delete"
        onclick="return confirm('Delete this product?')">Delete</button>
    </td>
</form>
</tr>
<?php endwhile; ?>
</table>

<h3>Add New Product</h3>
<form method="POST" class="add-customer">
    <input type="text" name="p_name" placeholder="Product Name" required>
    <input type="number" step="0.01" name="p_price" placeholder="Price" required>
    <input type="text" name="p_desc" placeholder="Description">
    <input type="text" name="p_image" placeholder="Image URL or filename">
    <button type="submit" name="add_product" class="edit">Add Product</button>
</form>

</div>
</body>
</html>