<?php
include '../koneksi.php';
session_start();

// Cek admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$cek = mysqli_query($koneksi, "SELECT role FROM users WHERE id='$uid'");
$role = mysqli_fetch_assoc($cek);

if ($role['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$promo = mysqli_query($koneksi, "SELECT * FROM promo ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Promo</title>
    <style>
        body { background:#111; color:#fff; font-family:poppins; }
        table { width:90%; margin:20px auto; background:#222; border-collapse:collapse; }
        th,td { padding:10px; text-align:center; }
        th { background:#ffcc00; color:#000; }
        a.btn { padding:6px 12px; border-radius:6px; text-decoration:none; color:#fff; }
        .add { background:#28a745; }
        .del { background:#dc3545; }
    </style>
</head>
<body>

<h2 style="text-align:center;color:#ffcc00;">Kelola Promo</h2>

<div style="text-align:center;margin-bottom:20px;">
    <a href="promo_tambah.php" class="btn add">+ Tambah Promo</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Game</th>
        <th>Diskon</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php while($p = mysqli_fetch_assoc($promo)): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['judul']) ?></td>
        <td><?= htmlspecialchars($p['game']) ?></td>
        <td>Rp<?= number_format($p['harga_diskon'],0,',','.') ?></td>
        <td><?= $p['aktif'] ? "Aktif" : "Tidak" ?></td>
        <td>
            <a href="promo_hapus.php?id=<?= $p['id'] ?>" class="btn del"
               onclick="return confirm('Hapus promo?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
