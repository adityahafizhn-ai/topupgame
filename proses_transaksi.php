<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $game = $_POST['game'];
    $id_game = $_POST['id_game'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $metode = $_POST['metode'];
    $status = "Menunggu";
    $tanggal = date('Y-m-d H:i:s');

    $query = "INSERT INTO transaksi (user_id, game, id_game, jumlah, harga, metode, status, tanggal)
              VALUES ('$user_id', '$game', '$id_game', '$jumlah', '$harga', '$metode', '$status', '$tanggal')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Transaksi berhasil dikirim!'); window.location='riwayat.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan!'); window.location='topup.php';</script>";
    }
}
?>
