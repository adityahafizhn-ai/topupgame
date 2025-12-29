<?php
include 'koneksi.php';
session_start();
$message = "";

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Ambil data user berdasarkan email
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    // Jika user ditemukan
    if ($row && password_verify($password, $row['password'])) {
        // Simpan data ke session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Arahkan berdasarkan role
        if ($row['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $message = "<div class='error'>Email atau password salah!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - CelleboyTopup</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?= $message ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn-yellow">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>
