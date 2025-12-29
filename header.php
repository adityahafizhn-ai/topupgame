<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="assets/images/logostick.png" alt="Celleboy Joki" height="50"></a>
                <span>Celleboy Store</span>
            </div>

            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="riwayat.php">Riwayat</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><span class="username">👋 Halo, <?= htmlspecialchars($_SESSION['username']); ?></span></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
