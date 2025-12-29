<?php
session_start();
include '../koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // kalau kamu pakai hash lain, ubah di sini

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['admin_username'] = $data['username'];
        header("Location: admin_transaksi.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Celleboy</title>
    <style>
        body {
            background: #0b0b0b;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: #1a1a1a;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(245, 196, 0, 0.25);
            width: 350px;
        }
        h2 {
            color: #f5c400;
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 10px;
            color: #fff;
            margin-bottom: 15px;
        }
        button {
            background: linear-gradient(90deg, #f5c400, #ffeb3b);
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
        .error {
            color: #ff5555;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login Admin</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username Admin" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>
