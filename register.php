<?php
include 'koneksi.php';
$message = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $hash     = password_hash($password, PASSWORD_BCRYPT);

    $check = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "<div class='error'>Email sudah digunakan!</div>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO users (username, email, password) VALUES ('$username','$email','$hash')");
        if ($insert) {
            $message = "<div class='success'>Pendaftaran berhasil! <a href='login.php'>Login sekarang</a></div>";
        } else {
            $message = "<div class='error'>Terjadi kesalahan saat registrasi.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - CelleboyTopup</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Daftar Akun</h2>
        <?= $message ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="btn-yellow">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
