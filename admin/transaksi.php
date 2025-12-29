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

// Ambil data transaksi penting saja
$query = "
    SELECT 
        t.id,
        u.username,
        t.game,
        t.jumlah,
        t.harga,
        t.status,
        t.tanggal
    FROM transaksi t
    JOIN users u ON t.user_id = u.id
    ORDER BY t.tanggal DESC
";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Transaksi</title>
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
h2 {
    text-align:center;
    margin:30px 0;
    color:#ffcc00;
}
table {
    width:90%;
    margin:0 auto 40px;
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
.status-sukses { color:#28a745; font-weight:600; }
.status-pending { color:#ffc107; font-weight:600; }

.btn {
    padding:6px 12px;
    border-radius:6px;
    font-weight:600;
    text-decoration:none;
    color:#fff;
}
.btn-success { background:#28a745; }
.btn-danger { background:#dc3545; }
</style>
</head>

<body>

<header>
    📦 DATA TRANSAKSI
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</header>

<nav>
    <a href="index.php">Dashboard</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan Bulanan</a>
</nav>

<h2>Daftar Transaksi</h2>

<table>
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Game</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['game']) ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td>Rp<?= number_format($row['harga'],0,',','.') ?></td>
    <td>
        <?php if ($row['status'] === 'Sukses'): ?>
            <span class="status-sukses">Sukses</span>
        <?php else: ?>
            <span class="status-pending">Pending</span>
        <?php endif; ?>
    </td>
    <td><?= $row['tanggal'] ?></td>
    <td>
        <?php if ($row['status'] !== 'Sukses'): ?>
            <a href="konfirmasi.php?id=<?= $row['id'] ?>" class="btn btn-success">Konfirmasi</a>
        <?php endif; ?>
        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger"
           onclick="return confirm('Yakin hapus transaksi ini?')">
           Hapus
        </a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
