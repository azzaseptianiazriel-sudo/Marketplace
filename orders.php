<?php
require_once __DIR__.'/includes/db.php';require_once __DIR__.'/includes/functions.php';require_login();
if(current_user()['role']==='admin')redirect('admin/orders.php');
$uid=(int)current_user()['id'];$s=$conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");$s->bind_param('i',$uid);$s->execute();$orders=$s->get_result();
$page_title='Pesanan Saya';require_once __DIR__.'/includes/header.php';
?>
<h1 class="section-title mb-4">Pesanan Saya</h1><?php if(!$orders->num_rows): ?><div class="empty-state">Kamu belum memiliki pesanan.</div><?php else: ?><div class="row g-3"><?php while($o=$orders->fetch_assoc()): ?><div class="col-12"><div class="surface-card p-4"><div class="d-flex justify-content-between flex-wrap gap-2"><strong>Pesanan #<?= (int)$o['id'] ?></strong><span class="badge bg-info text-dark"><?= e(ucfirst($o['status'])) ?></span></div><div class="text-secondary small"><?= e($o['created_at']) ?></div><div class="d-flex justify-content-between mt-3"><span>Total pembayaran</span><strong class="price"><?= rupiah($o['total_amount']) ?></strong></div></div></div><?php endwhile; ?></div><?php endif; ?>
<?php require_once __DIR__.'/includes/footer.php'; ?>
