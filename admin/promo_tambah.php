<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $desk = $_POST['deskripsi'];
    $game = $_POST['game'];
    $diskon = $_POST['diskon'];

    mysqli_query($koneksi, "INSERT INTO promo (judul, deskripsi, game, harga_diskon, aktif)
    VALUES ('$judul','$desk','$game','$diskon',1)");

    header("Location: promo.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Promo</title>
    <style>
        body{ background:#111; color:#fff; font-family:poppins; }
        form{ width:400px; margin:40px auto; background:#222; padding:20px; border-radius:10px; }
        input,textarea{ width:100%; padding:10px; margin:8px 0; border-radius:6px; }
        button{ padding:10px 20px; background:#ffcc00; border:none; cursor:pointer; font-weight:bold; }
    </style>
</head>
<body>

<h2 style="text-align:center;color:#ffcc00;">Tambah Promo</h2>

<form method="POST">
    <input type="text" name="judul" placeholder="Judul promo" required>
    <textarea name="deskripsi" placeholder="Deskripsi promo" required></textarea>
    <input type="text" name="game" placeholder="Game" required>
    <input type="number" name="diskon" placeholder="Harga Diskon" required>
    <button type="submit" name="tambah">Tambah</button>
</form>

</body>
</html>
