<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id = $id");

    if ($delete) {
        header("Location: index.php?msg=hapus_berhasil");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
