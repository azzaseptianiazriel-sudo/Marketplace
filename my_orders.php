<?php
require_once __DIR__.'/includes/db.php';require_once __DIR__.'/includes/functions.php';require_buyer();
$uid=(int)current_user()['id'];$stmt=$conn->prepare("SELECT id,order_code,total,status,created_at FROM orders WHERE buyer_id=? ORDER BY created_at DESC");$stmt->bind_param('i',$uid);$stmt->execute();$orders=$stmt->get_result();
$page_title='Pesanan Saya';require_once __DIR__.'/includes/header.php';
?>
<h1 class="h2 mb-4">Pesanan Saya</h1><div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead><tbody>
<?php if($orders->num_rows):while($o=$orders->fetch_assoc()): ?><tr><td><?= e($o['order_code']) ?></td><td><?= e($o['created_at']) ?></td><td><?= rupiah($o['total']) ?></td><td><span class="badge text-bg-info"><?= e($o['status']) ?></span></td></tr><?php endwhile;else: ?><tr><td colspan="4" class="text-center">Belum ada pesanan.</td></tr><?php endif; ?>
</tbody></table></div></div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
