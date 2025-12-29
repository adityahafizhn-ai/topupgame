<?php
include 'koneksi.php';
session_start();

/* =========================
   PRODUK TERLARIS
   ========================= */
$produk_laris = mysqli_query($koneksi, "
    SELECT game
    FROM transaksi
    WHERE status = 'Sukses'
    GROUP BY game
    ORDER BY COUNT(*) DESC
    LIMIT 3
");

/* =========================
   PROMO AKTIF
   ========================= */
$promo = mysqli_query($koneksi, "
    SELECT * FROM promo
    WHERE status = 'aktif'
    AND CURDATE() BETWEEN tanggal_mulai AND tanggal_selesai
    ORDER BY id DESC
");

/* =========================
   MAPPING GAMBAR GAME
   ========================= */
$gambar_game = [
    'Mobile Legends' => 'assets/images/mlbb.jpg',
    'Magic Chess'    => 'assets/images/magicchess.jpg',
    'Roblox'         => 'assets/images/roblox.jpg',
    'Free Fire'      => 'assets/images/freefire.jpg',
    'PUBG Mobile'    => 'assets/images/pubgm.jpg'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celleboy Store | Top Up Game Murah & Cepat</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<!-- ================= HERO ================= -->
<section class="hero">
    <div class="container hero-content">
        <h1>🔥 Top Up Game Favoritmu di <span>Celleboy Store</span> 🔥</h1>
        <p>Cepat, Aman, dan Terpercaya</p>
        <a href="#games" class="btn">Mulai Top Up</a>
    </div>
</section>

<!-- ================= PRODUK TERLARIS ================= -->
<section class="games">
    <div class="container">
        <h2>🔥 Produk Terlaris Bulan Ini</h2>

        <div class="game-list">
            <?php if (mysqli_num_rows($produk_laris) > 0): ?>
                <?php while ($p = mysqli_fetch_assoc($produk_laris)): ?>
                    <?php
                        $img = $gambar_game[$p['game']] ?? 'assets/images/default.jpg';
                    ?>
                    <div class="game-card"
                         onclick="window.location.href='topup.php?game=<?= urlencode($p['game']) ?>'">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['game']) ?>">
                        <h3><?= htmlspecialchars($p['game']) ?></h3>
                        <p>🔥 Rekomendasi pilihan terbaik</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center;color:#aaa;">Belum ada rekomendasi saat ini</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= PROMO ================= -->
<section class="games">
    <div class="container">
        <h2>🎁 Promo Spesial untuk Kamu</h2>

        <div class="game-list">
            <?php if (mysqli_num_rows($promo) > 0): ?>
                <?php while ($pr = mysqli_fetch_assoc($promo)): ?>
                    <div class="game-card">
                        <?php if (!empty($pr['gambar'])): ?>
                            <img src="assets/images/promo/<?= htmlspecialchars($pr['gambar']) ?>"
                                 alt="<?= htmlspecialchars($pr['judul']) ?>">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($pr['judul']) ?></h3>
                        <p><?= htmlspecialchars($pr['deskripsi']) ?></p>
                        <small>Berlaku sampai <?= $pr['tanggal_selesai'] ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center;color:#aaa;">Tidak ada promo aktif</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= GAME LIST ================= -->
<section class="games" id="games">
    <div class="container">
        <h2>🎮 Pilih Game</h2>

        <div class="game-list">
            <div class="game-card" onclick="window.location.href='topup.php?game=Mobile Legends'">
                <img src="assets/images/mlbb.jpg">
                <h3>Mobile Legends</h3>
                <p>Top up diamond cepat</p>
            </div>

            <div class="game-card" onclick="window.location.href='topup.php?game=Magic Chess'">
                <img src="assets/images/magicchess.jpg">
                <h3>Magic Chess</h3>
                <p>Push rank lebih mudah</p>
            </div>

            <div class="game-card" onclick="window.location.href='topup.php?game=Roblox'">
                <img src="assets/images/roblox.jpg">
                <h3>Roblox</h3>
                <p>Top up Robux aman</p>
            </div>

            <div class="game-card" onclick="window.location.href='topup.php?game=Free Fire'">
                <img src="assets/images/freefire.jpg">
                <h3>Free Fire</h3>
                <p>Diamond langsung masuk</p>
            </div>

            <div class="game-card" onclick="window.location.href='topup.php?game=PUBG Mobile'">
                <img src="assets/images/pubgm.jpg">
                <h3>PUBG Mobile</h3>
                <p>Top up UC instan</p>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
