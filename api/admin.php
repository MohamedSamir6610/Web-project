<?php
include '../db.php';
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // ADD CUSTOMER
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

    // EDIT CUSTOMER (BY EMAIL)
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

    // DELETE CUSTOMER (BY EMAIL)
    if(isset($_POST['delete_customer'])){
        $email = $_POST['email'];
        $conn->query("DELETE FROM customer WHERE email='$email'");
    }

    header("Location: admin.php");
    exit;
}

$customer = $conn->query("SELECT * FROM customer");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Customers</title>
<link rel="stylesheet" href="admin.css">
</head>

<body>
<div class="container">

<h1>Admin Panel - Customers</h1>

<form method="POST" style="text-align:right;">
    <button type="submit" class="logout" formaction="logout.php">Logout</button>
</form>

<h2>Customer List</h2>

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

    <td>
        <input type="text" name="name"
        value="<?php echo $row['name']; ?>" required>
    </td>

    <td>
        <input type="email" name="email"
        value="<?php echo $row['email']; ?>" readonly>
    </td>

    <td>
        <input type="text" name="phone"
        value="<?php echo $row['phone']; ?>">
    </td>

    <td>
        <input type="password"
        value="<?php echo $row['password']; ?>" readonly>
    </td>

    <td>
        <button type="submit" name="edit_customer" class="edit">
            Edit
        </button>
    </td>

    <td>
        <button type="submit" name="delete_customer" class="delete"
        onclick="return confirm('Are you sure you want to delete this customer?')">
            Delete
        </button>
    </td>

</form>
</tr>
<?php endwhile; ?>

</table>

<h2>Add New Customer</h2>

<form method="POST" class="add-customer">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="add_customer" class="edit">
        Add Customer
    </button>
</form>

</div>
</body>
</html>