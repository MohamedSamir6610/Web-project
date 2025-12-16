 ======= MENU ITEMS CRUD =======
<?php
include '../db.php';
session_start();
    // ADD ITEM
    if(isset($_POST['add_item'])){
        $name  = $_POST['item_name'];
        $desc  = $_POST['item_desc'];
        $price = $_POST['item_price'];
        $conn->query("INSERT INTO menu_items (name, description, price) VALUES ('$name','$desc','$price')");
    }

    // EDIT ITEM
    if(isset($_POST['edit_item'])){
        $id    = $_POST['edit_item'];
        $name  = $_POST['item_name'];
        $desc  = $_POST['item_desc'];
        $price = $_POST['item_price'];
        $conn->query("UPDATE menu_items SET name='$name', description='$desc', price='$price' WHERE id=$id");
    }

    // DELETE ITEM
    if(isset($_POST['delete_item'])){
        $id = $_POST['delete_item'];
        $conn->query("DELETE FROM menu_items WHERE id=$id");
    }

    header("Location: admin.php");
    exit;

$menu_items = $conn->query("SELECT * FROM menu_items");
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
<!-- ====== Menu Items Table ====== -->
<h2>Menu Items List</h2>
<table>
<tr>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>

<?php while($row = $menu_items->fetch_assoc()): ?>
<tr>
<form method="POST">
    <td><input type="text" name="item_name" value="<?php echo $row['name']; ?>" required></td>
    <td><textarea name="item_desc"><?php echo $row['description']; ?></textarea></td>
    <td><input type="number" step="0.01" name="item_price" value="<?php echo $row['price']; ?>" required></td>
    <td><button type="submit" name="edit_item" value="<?php echo $row['id']; ?>">Edit</button></td>
    <td><button type="submit" name="delete_item" value="<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</button></td>
</form>
</tr>
<?php endwhile; ?>
</table>

<h3>Add New Menu Item</h3>
<form method="POST" class="add-menu-item">
    <input type="text" name="item_name" placeholder="Item Name" required>
    <textarea name="item_desc" placeholder="Description"></textarea>
    <input type="number" step="0.01" name="item_price" placeholder="Price" required>
    <button type="submit" name="add_item" class="edit">Add Item</button>
</form>

</div>
</body>
</html>