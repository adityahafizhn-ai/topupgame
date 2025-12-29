<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "UPDATE transaksi SET status = 'Sukses' WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: index.php?msg=berhasil");
        exit;
    } else {
        echo "Gagal mengubah status: " . mysqli_error($koneksi);
    }
} else {
    echo "ID transaksi tidak ditemukan!";
}
?>
