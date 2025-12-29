<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '';
$game = $_GET['game'] ?? '';
$game_lower = strtolower($game);

/* ===============================
   SET ITEM & HARGA BERDASARKAN GAME
================================ */
$prices = [];
$item_label = 'Diamond';
$item_icon = 'diamond.png';
$need_id = true;

if ($game_lower == 'mobile legends') {
    $prices = [
        ['80 Diamond',20000],
        ['180 Diamond',50000],
        ['370 Diamond',100000],
        ['568 Diamond',150000],
        ['750 Diamond',200000],
        ['966 Diamond',250000],
        ['1136 Diamond',300000],
        ['1358 Diamond',350000],
        ['1506 Diamond',400000],
    ];
}if ($game_lower == 'magic chess') {
    $prices = [
        ['80 Diamond',20000],
        ['180 Diamond',50000],
        ['370 Diamond',100000],
        ['568 Diamond',150000],
        ['750 Diamond',200000],
        ['966 Diamond',250000],
        ['1136 Diamond',300000],
        ['1358 Diamond',350000],
        ['1506 Diamond',400000],
    ];
}
if ($game_lower == 'free fire') {
    $prices = [
        ['80 Diamond',20000],
        ['180 Diamond',50000],
        ['370 Diamond',100000],
        ['568 Diamond',150000],
        ['750 Diamond',200000],
        ['966 Diamond',250000],
        ['1136 Diamond',300000],
        ['1358 Diamond',350000],
        ['1506 Diamond',400000],
    ];
}
elseif ($game_lower == 'pubg mobile') {
    $item_label = 'UC';
    $item_icon = 'uc.png';
    $prices = [
        ['60 UC',15000],
        ['325 UC',75000],
        ['660 UC',150000],
        ['1800 UC',400000],
    ];
}
elseif ($game_lower == 'roblox') {
    $item_label = 'Gift Card';
    $item_icon = 'roblox.png';
    $need_id = false;
    $prices = [
        ['Gift Card',50000],
        ['Gift Card',100000],
        ['Gift Card',200000],
        ['Gift Card',500000],
    ];
}

/* ===============================
   PROSES PESANAN
================================ */
if (isset($_POST['pesan'])) {
    $nickname = mysqli_real_escape_string($koneksi, $_POST['nickname']);
    $id_game  = $need_id ? mysqli_real_escape_string($koneksi, $_POST['id_game']) : '-';
    $server   = $need_id ? mysqli_real_escape_string($koneksi, $_POST['server']) : '-';
    $nominal  = mysqli_real_escape_string($koneksi, $_POST['nominal']);
    $harga    = (int) $_POST['harga'];
    $kontak   = mysqli_real_escape_string($koneksi, $_POST['kontak']);

    mysqli_query($koneksi, "
        INSERT INTO transaksi 
        (user_id, game, id_game, jumlah, harga, metode, status, tanggal)
        VALUES 
        ('$user_id','$game','$nickname | $id_game-$server','$nominal','$harga','QRIS','Menunggu Pembayaran',NOW())
    ");

    header("Location: pembayaran.php?id=".mysqli_insert_id($koneksi));
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Top Up <?= htmlspecialchars($game) ?></title>
<link rel="stylesheet" href="assets/css/style.css">

<style>
.topup-section{padding:60px 20px;background:#0b0b0b;min-height:100vh}
.topup-box{max-width:800px;margin:auto;background:#1a1a1a;padding:35px;border-radius:18px;color:#fff}
.topup-box h2{text-align:center;margin-bottom:30px;color:#f5c400}

label{margin-top:18px;display:block;font-weight:600;color:#f5c400}
input{width:100%;padding:12px;border-radius:10px;border:1px solid #333;background:#0d0d0d;color:#fff;margin-top:8px}

.price-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:18px;margin-top:20px}
.price-card{background:#111;border:1px solid #333;border-radius:14px;padding:18px;text-align:center;cursor:pointer}
.price-card.active{border:2px solid #f5c400}
.price-card img{width:40px;margin-bottom:10px}
.price-card h4{margin-bottom:6px}
.price-card p{color:#f5c400;font-weight:700}

.total-box{margin-top:25px;font-size:18px}
.btn-submit{margin-top:25px;width:100%;padding:14px;border:none;border-radius:12px;font-weight:700;background:linear-gradient(90deg,#f5c400,#ffeb3b)}
</style>
</head>

<body>
<?php include 'header.php'; ?>

<section class="topup-section">
<div class="topup-box">
<h2><?= htmlspecialchars($game) ?> Top Up</h2>

<form method="POST" id="formTopup">

<label>Nickname</label>
<input type="text" name="nickname" required>

<?php if ($need_id): ?>
<label>ID Game</label>
<input type="text" name="id_game" required>

<label>Server</label>
<input type="text" name="server" required>
<?php endif; ?>

<label>Pilih Nominal</label>
<div class="price-grid">
<?php foreach($prices as $p): ?>
<div class="price-card" onclick="pilih('<?= $p[0] ?>',<?= $p[1] ?>)">
<img src="assets/images/<?= $item_icon ?>">
<h4><?= $p[0] ?></h4>
<p>Rp<?= number_format($p[1],0,',','.') ?></p>
</div>
<?php endforeach; ?>
</div>

<input type="hidden" name="nominal" id="nominal">
<input type="hidden" name="harga" id="harga">

<div class="total-box">
Total: <b id="totalText">Rp0</b>
</div>

<label>Pembayaran</label>
<input type="text" value="QRIS" disabled>

<label>Kontak (WA / Email)</label>
<input type="text" name="kontak" required>

<button type="submit" name="pesan" class="btn-submit">Pesan Sekarang</button>
</form>
</div>
</section>

<script>
function pilih(nominal,harga){
    document.querySelectorAll('.price-card').forEach(c=>c.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.getElementById('nominal').value = nominal;
    document.getElementById('harga').value = harga;
    document.getElementById('totalText').innerText = 'Rp'+harga.toLocaleString('id-ID');
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
