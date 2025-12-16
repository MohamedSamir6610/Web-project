<?php
include 'db.php'; 

$products = $conn->query("SELECT * FROM product") or die("Error: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUNARE Café - Menu</title>
    <link rel="stylesheet" href="menu.css"> 
</head>
<body>

<div class="navbar">
    <h2>LUNARE Café</h2>
    <div class="nav-links">
        <a href="home.html">Home</a>
        <a href="about.html">About</a>
        <a href="menu.php">Menu</a>
        <a href="contact.html">Contact</a>
        <a href="log in .html">Log In</a>
    </div>
</div>

<section class="menu">
    <h2 style="text-align:center; margin-top:30px;">Drinks & Desserts</h2>
    <div class="menu-grid">
        <?php while($p = $products->fetch_assoc()): ?>
            <div class="menu-item" data-name="<?php echo $p['name']; ?>" data-price="<?php echo $p['price']; ?>" data-desc="<?php echo $p['description']; ?>" data-img="<?php echo $p['image']; ?>">
                <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['name']; ?>">
                <h3><?php echo $p['name']; ?></h3>
                <span class="price"><?php echo $p['price']; ?> EGP</span>
                <button class="add-to-cart" data-name="<?php echo $p['name']; ?>" data-price="<?php echo $p['price']; ?>" data-desc="<?php echo $p['description']; ?>" data-img="<?php echo $p['image']; ?>">Add to Cart</button>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="menu.js"></script>

</body>
</html>