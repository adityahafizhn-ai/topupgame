<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query_user = mysqli_query($koneksi, "SELECT username FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query_user);

// Ambil data transaksi
$query_transaksi = mysqli_query($koneksi, "
    SELECT id, game, id_game, jumlah, harga, metode, status, tanggal, bukti_pembayaran
    FROM transaksi 
    WHERE user_id = '$user_id'
    ORDER BY tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi - Celleboy</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* ====== Tampilan Badge Status ====== */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            text-transform: capitalize;
            transition: 0.3s ease;
        }

        .status-menunggu {
            background: linear-gradient(90deg, #fbc02d, #fff176);
            color: #000;
        }

        .status-verifikasi {
            background: linear-gradient(90deg, #29b6f6, #4fc3f7);
            color: #fff;
        }

        .status-selesai {
            background: linear-gradient(90deg, #66bb6a, #43a047);
            color: #fff;
        }

        .status-gagal {
            background: linear-gradient(90deg, #ef5350, #e53935);
            color: #fff;
        }

        /* ====== Tombol Upload / Lihat Bukti ====== */
        .upload-form {
            margin-top: 8px;
        }

        .upload-btn {
            background: #fdd835;
            color: #000;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-btn:hover {
            background: #fff;
            color: #000;
        }

        .lihat-bukti {
            display: inline-block;
            background: linear-gradient(90deg, #007bff, #2196f3);
            color: #fff !important;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 8px;
            transition: 0.3s ease;
        }

        .lihat-bukti:hover {
            background: linear-gradient(90deg, #2196f3, #42a5f5);
        }

        /* ====== Table Styling ====== */
        .riwayat-container {
            padding: 40px;
            color: #fff;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 15px;
        }

        th, td {
            border: 1px solid rgba(255,255,255,0.1);
            padding: 10px;
        }

        th {
            background: #f5c400;
            color: #000;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background: #1a1a1a;
        }

        tr:nth-child(odd) {
            background: #111;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="riwayat-container">
    <h2>Riwayat Transaksi <?= htmlspecialchars($user['username']); ?></h2>

    <?php if (mysqli_num_rows($query_transaksi) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Game</th>
                    <th>ID Game</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_transaksi)): ?>
                    <?php
                        $statusClass = 'status-menunggu';
                        if ($row['status'] == 'Menunggu Pembayaran') $statusClass = 'status-menunggu';
                        elseif ($row['status'] == 'Menunggu Verifikasi') $statusClass = 'status-verifikasi';
                        elseif ($row['status'] == 'Selesai') $statusClass = 'status-selesai';
                        elseif ($row['status'] == 'Gagal') $statusClass = 'status-gagal';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['game']); ?></td>
                        <td><?= htmlspecialchars($row['id_game']); ?></td>
                        <td><?= htmlspecialchars($row['jumlah']); ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($row['metode']); ?></td>
                        <td>
                            <span class="status-badge <?= $statusClass; ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                            <br>
                            
                        </td>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color:#ccc; margin-top:20px;">Belum ada transaksi yang tercatat.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
