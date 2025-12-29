<?php
include '../koneksi.php';
session_start();

// Proteksi login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$check = mysqli_query($koneksi, "SELECT role FROM users WHERE id='$user_id'");
$userData = mysqli_fetch_assoc($check);
if ($userData['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// DATA DASHBOARD
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS total FROM transaksi"
))['total'];

$pendapatanBulan = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT SUM(harga) AS total FROM transaksi 
     WHERE status='Sukses' 
     AND MONTH(tanggal)=MONTH(CURDATE()) 
     AND YEAR(tanggal)=YEAR(CURDATE())"
))['total'];

$pending = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS total FROM transaksi WHERE status!='Sukses'"
))['total'];

$laris = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT game, COUNT(*) AS jumlah 
     FROM transaksi 
     WHERE status='Sukses'
     GROUP BY game 
     ORDER BY jumlah DESC 
     LIMIT 1"
));

// Transaksi terbaru
$latest = mysqli_query($koneksi,
    "SELECT t.*, u.username 
     FROM transaksi t 
     JOIN users u ON t.user_id=u.id 
     ORDER BY t.tanggal DESC 
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background:#0d0d0d;
    color:#fff;
    margin:0;
}
header {
    background:#111;
    padding:15px 30px;
    color:#ffcc00;
    font-size:20px;
    font-weight:700;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:3px solid #ffcc00;
}
nav {
    background:#1a1a1a;
    padding:10px;
    text-align:center;
}
nav a {
    color:#ffcc00;
    margin:0 15px;
    text-decoration:none;
    font-weight:600;
}
.container {
    width:95%;
    margin:30px auto;
}
.cards {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.card {
    background:#1a1a1a;
    padding:20px;
    border-radius:12px;
}
.card h3 {
    color:#aaa;
    font-size:14px;
}
.card p {
    font-size:24px;
    font-weight:700;
    color:#ffcc00;
}
table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th, td {
    padding:10px;
    text-align:center;
}
th {
    background:#ffcc00;
    color:#000;
}
tr:nth-child(even) {
    background:#222;
}
.btn {
    background:#007bff;
    padding:6px 12px;
    border-radius:6px;
    color:#fff;
    text-decoration:none;
    font-size:12px;
}
</style>
</head>

<body>

<header>
    ⚙️ ADMIN DASHBOARD
    <a href="../logout.php" class="btn">Logout</a>
</header>

<nav>
    <a href="index.php">Dashboard</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan Bulanan</a>
    
</nav>

<div class="container">

<!-- SUMMARY -->
<div class="cards">
    <div class="card">
        <h3>Total Transaksi</h3>
        <p><?= $totalTransaksi ?></p>
    </div>
    <div class="card">
        <h3>Pendapatan Bulan Ini</h3>
        <p>Rp<?= number_format($pendapatanBulan ?? 0,0,',','.') ?></p>
    </div>
    <div class="card">
        <h3>Menunggu Konfirmasi</h3>
        <p><?= $pending ?></p>
    </div>
    <div class="card">
        <h3>Produk Terlaris</h3>
        <p><?= $laris['game'] ?? '-' ?></p>
    </div>
</div>

<!-- TRANSAKSI TERBARU -->
<h3 style="margin-top:40px;color:#ffcc00;">Transaksi Terbaru</h3>

<table>
<tr>
    <th>User</th>
    <th>Game</th>
    <th>Harga</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($latest)): ?>
<tr>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['game']) ?></td>
    <td>Rp<?= number_format($row['harga'],0,',','.') ?></td>
    <td><?= htmlspecialchars($row['status']) ?></td>
</tr>
<?php endwhile; ?>
</table>

<a href="transaksi.php" class="btn" style="margin-top:15px;display:inline-block;">
    Lihat Semua Transaksi
</a>

</div>

</body>
</html>
