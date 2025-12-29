<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaksi_id = $_POST['transaksi_id'];
    $user_id = $_SESSION['user_id'];

    // Cek apakah file diupload
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['bukti']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['bukti']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $fileName;

        // Buat folder kalau belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Pindahkan file
        if (move_uploaded_file($fileTmp, $targetFile)) {
            // Update bukti pembayaran + ubah status jadi Menunggu Verifikasi
            $update = mysqli_query($koneksi, "
                UPDATE transaksi 
                SET bukti_pembayaran = '$fileName', status = 'Menunggu Verifikasi'
                WHERE id = '$transaksi_id' AND user_id = '$user_id'
            ");

            if ($update) {
                echo "<script>alert('Bukti pembayaran berhasil diupload!'); window.location='riwayat.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database!'); window.location='riwayat.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupload file.'); window.location='riwayat.php';</script>";
        }
    } else {
        echo "<script>alert('Tidak ada file yang diupload.'); window.location='riwayat.php';</script>";
    }
}
?>
