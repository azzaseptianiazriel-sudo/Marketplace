<?php
require_once __DIR__ . '/includes/functions.php';
require_login();
$code=$_SESSION['last_order'] ?? '';
$page_title='Pesanan Berhasil'; require_once __DIR__ . '/includes/header.php';
?>
<div class="card p-5 text-center">
<div class="display-4 mb-3">✓</div><h2>Pesanan berhasil dibuat!</h2>
<p class="text-muted">Nomor pesanan kamu: <strong><?= e($code) ?></strong></p>
<a href="orders.php" class="btn btn-primary mx-auto">Lihat Pesanan Saya</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
