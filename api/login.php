<?php
session_start();

// Allowed users
$users = [
    "Mohamed" => "1",
    "Shahd" => "2",
    "Ragy" => "3",
    "Salma" => "4",
    "Roqaya" => "5"
];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Incorrect username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #1f1c2c, #928dab);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .login-container {
        background: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        width: 350px;
        text-align: center;
    }
    h2 {
        margin-bottom: 25px;
        color: #333;
        font-size: 24px;
    }
    input[type="text"], input[type="password"] {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }
    button {
        width: 95%;
        padding: 12px;
        background: #6a11cb;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        border: none;
        color: #fff;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }
    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .error {
        color: #ff4d4d;
        margin-bottom: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if($error) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>