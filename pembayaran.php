<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit();
}

$id = (int)$_GET['id'];
$q  = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<script>alert('Invoice tidak ditemukan');location='riwayat.php';</script>";
    exit;
}

/* DATA */
$game   = $data['game'];
$idGame = $data['id_game'];
$jumlah = $data['jumlah'];
$harga  = $data['harga'];
$status = $data['status'];
$metode = $data['metode'];

/* QRIS ONLY */
if ($metode !== 'QRIS') {
    echo "<script>alert('Metode pembayaran tidak tersedia');location='riwayat.php';</script>";
    exit;
}

/* GAMBAR GAME */
$gameImage = 'assets/images/game/default.png';
if (stripos($game, 'mobile legends') !== false)      $gameImage = 'assets/images/game/mlbb.jpg';
elseif (stripos($game, 'pubg') !== false)            $gameImage = 'assets/images/game/pubgm.jpg';
elseif (stripos($game, 'free fire') !== false)       $gameImage = 'assets/images/game/freefire.jpg';
elseif (stripos($game, needle: 'roblox') !== false)        $gameImage = 'assets/images/game/roblox.jpg';
elseif (stripos($game, needle: 'magicchess') !== false)        $gameImage = 'assets/images/game/magicchess.jpg';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran QRIS</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>
    /* ================= SPACING FIX ================= */

/* Judul */
.payment-page h2 {
    margin-bottom: 20px;
}

/* Card spacing */
.payment-page .card {
    padding: 35px;
}

/* Detail Game */
.game-box {
    margin-top: 15px;
    margin-bottom: 30px;
}

.game-info h3 {
    margin-bottom: 14px;
}

.game-info .row {
    margin-bottom: 10px;
    line-height: 1.6;
}

/* Garis pemisah */
.hr {
    margin: 30px 0;
}

/* Rincian pembayaran */
.row-flex {
    margin-bottom: 14px;
    line-height: 1.6;
}

/* Total */
.total {
    margin-top: 15px;
    font-size: 22px;
}

/* Status */
.badge {
    display: inline-block;
    margin: 15px 0 25px;
}

/* QR Section */
.qr {
    margin: 30px auto;
}

/* Button */
.btn {
    margin-top: 20px;
}

/* SCOPE AMAN */
.payment-page{background:#0b0b0b;color:#fff;padding:40px 0}
.payment-page .container{max-width:1100px;margin:auto;padding:0 20px}
.payment-page .grid{display:grid;grid-template-columns:2fr 1.2fr;gap:30px}
.payment-page .card{background:#1a1a1a;border-radius:18px;padding:30px}

/* INFO GAME */
.game-box{display:flex;gap:25px;align-items:center}
.game-box img{width:140px;height:140px;object-fit:cover;border-radius:16px;border:3px solid #f5c400}
.game-info h3{margin:0 0 12px}
.game-info .row{margin-bottom:8px;color:#ccc}

/* PEMBAYARAN */
.hr{height:1px;background:#333;margin:25px 0}
.row-flex{display:flex;justify-content:space-between;color:#ccc;margin-bottom:10px}
.total{font-size:20px;font-weight:700;color:#f5c400}

/* QR */
.center{text-align:center}
.qr{width:240px;border-radius:16px;border:4px solid #f5c400;margin:20px auto}
.badge{padding:6px 16px;border-radius:20px;font-size:13px;font-weight:700}
.badge-wait{background:#fbc02d;color:#000}
.badge-ok{background:#4caf50}

/* BUTTON */
.btn{padding:12px 30px;border:none;border-radius:12px;
background:linear-gradient(90deg,#f5c400,#ffeb3b);
font-weight:700;cursor:pointer}
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="payment-page">
  <div class="container">
    <div class="grid">

      <!-- KIRI -->
      <div class="card">

        <h2>Detail Pesanan</h2>

        <div class="game-box">
            <img src="<?= $gameImage ?>" alt="Game">
            <div class="game-info">
                <h3><?= htmlspecialchars($game) ?></h3>
                <div class="row">ID Game: <?= htmlspecialchars($idGame) ?></div>
                <div class="row">Jumlah: <?= htmlspecialchars($jumlah) ?></div>
            </div>
        </div>

        <div class="hr"></div>

        <h3>Rincian Pembayaran</h3>
        <div class="row-flex">
            <span>Metode</span>
            <span>QRIS</span>
        </div>
        <div class="row-flex total">
            <span>Total Bayar</span>
            <span>Rp<?= number_format($harga,0,',','.') ?></span>
        </div>

      </div>

      <!-- KANAN -->
      <div class="card center">
        <h2>Pembayaran QRIS</h2>

        <p>Status</p>
        <span class="badge <?= $status=='Selesai'?'badge-ok':'badge-wait' ?>">
            <?= htmlspecialchars($status) ?>
        </span>

        <img src="assets/images/qr-qris.png" class="qr" alt="QRIS">

        <p style="color:#aaa;font-size:14px">
          Scan QRIS untuk menyelesaikan pembayaran
        </p>

        <a href="riwayat.php">
            <button class="btn">Saya Sudah Bayar</button>
        </a>
      </div>

    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
