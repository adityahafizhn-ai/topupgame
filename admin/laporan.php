<?php
include '../koneksi.php';
session_start();

// Proteksi admin
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

// Filter bulan & tahun
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Ringkasan
$ringkasan = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT 
        COUNT(*) AS total_transaksi,
        SUM(harga) AS total_pendapatan
    FROM transaksi
    WHERE status='Sukses'
    AND MONTH(tanggal)='$bulan'
    AND YEAR(tanggal)='$tahun'
"));

// Produk terlaris
$terlaris = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT game, COUNT(*) AS jumlah
    FROM transaksi
    WHERE status='Sukses'
    AND MONTH(tanggal)='$bulan'
    AND YEAR(tanggal)='$tahun'
    GROUP BY game
    ORDER BY jumlah DESC
    LIMIT 1
"));

// Rekap per game
$rekap = mysqli_query($koneksi, "
    SELECT game, COUNT(*) AS total, SUM(harga) AS pendapatan
    FROM transaksi
    WHERE status='Sukses'
    AND MONTH(tanggal)='$bulan'
    AND YEAR(tanggal)='$tahun'
    GROUP BY game
    ORDER BY pendapatan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bulanan</title>
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
    width:90%;
    margin:30px auto;
}
h2 {
    text-align:center;
    color:#ffcc00;
}
.filter {
    text-align:center;
    margin:20px 0;
}
select, button {
    padding:8px 12px;
    border-radius:6px;
    border:none;
    margin:5px;
}
button {
    background:#ffcc00;
    font-weight:600;
    cursor:pointer;
}
.cards {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:30px;
}
.card {
    background:#1a1a1a;
    padding:20px;
    border-radius:12px;
    text-align:center;
}
.card p {
    margin:5px 0;
}
.card .label {
    color:#aaa;
    font-size:14px;
}
.card .value {
    font-size:24px;
    font-weight:700;
    color:#ffcc00;
}
table {
    width:100%;
    margin-top:30px;
    border-collapse:collapse;
    background:#1a1a1a;
    border-radius:12px;
    overflow:hidden;
}
th, td {
    padding:12px;
    text-align:center;
}
th {
    background:#ffcc00;
    color:#000;
}
tr:nth-child(even) {
    background:#222;
}
.footer-note {
    margin-top:20px;
    color:#aaa;
    font-size:13px;
    text-align:right;
}
</style>
</head>

<body>

<header>
    📊 LAPORAN BULANAN
    <a href="../logout.php" style="color:#000;background:#ffcc00;padding:6px 12px;border-radius:6px;text-decoration:none;">Logout</a>
</header>

<nav>
    <a href="index.php">Dashboard</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan Bulanan</a>
</nav>

<div class="container">

<h2>Laporan Penjualan</h2>

<div class="filter">
<form method="GET">
    <select name="bulan">
        <?php for($i=1;$i<=12;$i++): ?>
        <option value="<?= $i ?>" <?= ($bulan==$i)?'selected':'' ?>>
            <?= date('F', mktime(0,0,0,$i,10)) ?>
        </option>
        <?php endfor; ?>
    </select>

    <select name="tahun">
        <?php for($y=2023;$y<=date('Y');$y++): ?>
        <option value="<?= $y ?>" <?= ($tahun==$y)?'selected':'' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

    <button type="submit">Tampilkan</button>
</form>
</div>

<!-- RINGKASAN -->
<div class="cards">
    <div class="card">
        <p class="label">Total Transaksi</p>
        <p class="value"><?= $ringkasan['total_transaksi'] ?? 0 ?></p>
    </div>
    <div class="card">
        <p class="label">Total Pendapatan</p>
        <p class="value">Rp<?= number_format($ringkasan['total_pendapatan'] ?? 0,0,',','.') ?></p>
    </div>
    <div class="card">
        <p class="label">Produk Terlaris</p>
        <p class="value"><?= $terlaris['game'] ?? '-' ?></p>
    </div>
</div>

<!-- TABEL REKAP -->
<table>
<tr>
    <th>Game</th>
    <th>Total Transaksi</th>
    <th>Total Pendapatan</th>
</tr>

<?php while($row = mysqli_fetch_assoc($rekap)): ?>
<tr>
    <td><?= htmlspecialchars($row['game']) ?></td>
    <td><?= $row['total'] ?></td>
    <td>Rp<?= number_format($row['pendapatan'],0,',','.') ?></td>
</tr>
<?php endwhile; ?>
</table>

<p class="footer-note">
    Data berdasarkan transaksi berstatus <b>Sukses</b>
</p>

</div>

</body>
</html>
