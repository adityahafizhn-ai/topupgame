<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM promo WHERE id='$id'");

header("Location: promo.php");
exit;
?>
