<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$id=(int)($_GET['id']??0);
$stmt=$conn->prepare("SELECT p.*,c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1");
$stmt->bind_param('i',$id);$stmt->execute();$p=$stmt->get_result()->fetch_assoc();
if(!$p){http_response_code(404);exit('Produk tidak ditemukan.');}
$page_title=$p['name'];require_once __DIR__.'/includes/header.php';
?>
<div class="row g-4 align-items-start">
<div class="col-lg-6"><img class="product-detail-img" src="<?= e(url($p['image'])) ?>" alt="<?= e($p['name']) ?>"></div>
<div class="col-lg-6"><a href="<?= e(url('index.php')) ?>" class="text-decoration-none">← Kembali ke produk</a>
<div class="mt-3"><span class="badge text-bg-light"><?= e($p['category_name']??'Umum') ?></span><h1 class="mt-2"><?= e($p['name']) ?></h1><div class="price fs-3 mb-3"><?= rupiah($p['price']) ?></div>
<p><?= nl2br(e($p['description'])) ?></p><p><strong>Stok tersedia:</strong> <?= (int)$p['stock'] ?></p>
<?php if($p['stock']>0): ?><form method="post" action="<?= e(url('add_to_cart.php')) ?>" class="card p-3">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
<label class="form-label">Jumlah</label><input class="form-control mb-3" type="number" name="qty" min="1" max="<?= (int)$p['stock'] ?>" value="1" required>
<button class="btn btn-primary btn-lg">Tambah ke Keranjang</button></form><?php else: ?><button class="btn btn-secondary" disabled>Stok Habis</button><?php endif; ?>
</div></div></div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
