<?php
require_once __DIR__.'/includes/db.php'; require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);
$stmt=$conn->prepare("SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1");
$stmt->bind_param('i',$id);$stmt->execute();$p=$stmt->get_result()->fetch_assoc();
if(!$p){http_response_code(404);exit('Produk tidak ditemukan.');}
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$qty=max(1,(int)($_POST['quantity']??1));if($qty>(int)$p['stock']){set_flash('Jumlah melebihi stok yang tersedia.','warning');redirect('product.php?id='.$id);}$_SESSION['cart'][$id]=min((int)$p['stock'],($_SESSION['cart'][$id]??0)+$qty);set_flash('Produk ditambahkan ke keranjang.');redirect('cart.php');}
$page_title=$p['name'];require_once __DIR__.'/includes/header.php';
?>
<div class="row g-4 align-items-start"><div class="col-lg-6"><img class="detail-img" src="<?= e(product_image($p['image_url'])) ?>" alt="<?= e($p['name']) ?>"></div><div class="col-lg-6"><div class="small text-secondary mb-2"><?= e($p['category_name']??'Produk') ?></div><h1 class="fw-bold"><?= e($p['name']) ?></h1><div class="price fs-3 my-3"><?= rupiah($p['price']) ?></div><p class="text-secondary"><?= nl2br(e($p['description'])) ?></p><p>Stok tersedia: <strong><?= (int)$p['stock'] ?></strong></p>
<?php if($p['stock']>0): ?><form method="post" class="d-flex gap-2 align-items-end"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><div><label class="form-label">Jumlah</label><input class="form-control" type="number" name="quantity" min="1" max="<?= (int)$p['stock'] ?>" value="1" style="width:110px"></div><button class="btn btn-primary btn-lg">Tambah ke Keranjang</button></form><?php else: ?><span class="badge bg-danger">Stok habis</span><?php endif; ?>
</div></div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
