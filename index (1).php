<?php
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/functions.php';
$q = trim($_GET['q'] ?? '');
$category = (int)($_GET['category'] ?? 0);
$sql = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.is_active=1";
$params = []; $types = '';
if ($q !== '') { $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)"; $like = "%$q%"; $params[]=$like; $params[]=$like; $types.='ss'; }
if ($category > 0) { $sql .= " AND p.category_id=?"; $params[]=$category; $types.='i'; }
$sql .= " ORDER BY p.created_at DESC";
$stmt=$conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute(); $products=$stmt->get_result();
$categories=$conn->query("SELECT id,name FROM categories ORDER BY name");
$page_title='Belanja kebutuhan harian';
require_once __DIR__.'/includes/header.php';
?>
<section class="hero rounded-4 p-4 p-lg-5 mb-4">
 <div class="row align-items-center"><div class="col-lg-7">
  <span class="hero-tag">Belanja lokal, lebih praktis</span>
  <h1 class="display-5 fw-bold mt-3">Belanja kebutuhan harian jadi lebih mudah.</h1>
  <p class="lead mb-4">Temukan bahan pokok, sayuran, buah-buahan, dan produk pilihan di MarketKita.</p>
  <a class="btn btn-warning btn-lg" href="#produk">Mulai Belanja</a>
 </div><div class="col-lg-5 d-none d-lg-block"><img class="hero-img" src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=900&auto=format&fit=crop&q=85" alt="Sayuran segar"></div></div>
</section>
<section id="produk">
 <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-3">
  <div><span class="eyebrow">Pilihan untukmu</span><h2 class="section-title mb-0">Daftar Produk</h2></div>
  <form class="d-flex gap-2" method="get"><input class="form-control" name="q" placeholder="Cari produk..." value="<?= e($q) ?>"><select class="form-select" name="category"><option value="0">Semua kategori</option><?php while($c=$categories->fetch_assoc()): ?><option value="<?= (int)$c['id'] ?>" <?= $category===(int)$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endwhile; ?></select><button class="btn btn-primary">Cari</button></form>
 </div>
 <div class="row g-4">
 <?php if($products->num_rows): while($p=$products->fetch_assoc()): ?>
  <div class="col-6 col-md-4 col-lg-3"><article class="product-card h-100">
   <a href="<?= e(url('product.php?id='.(int)$p['id'])) ?>"><img src="<?= e(product_image($p['image_url'])) ?>" alt="<?= e($p['name']) ?>" class="product-img" loading="lazy"></a>
   <div class="p-3"><div class="small text-secondary mb-1"><?= e($p['category_name'] ?? 'Produk') ?></div><h3 class="product-name"><a href="<?= e(url('product.php?id='.(int)$p['id'])) ?>"><?= e($p['name']) ?></a></h3><div class="price"><?= rupiah($p['price']) ?></div><div class="small text-secondary mb-3">Stok: <?= (int)$p['stock'] ?></div>
   <a class="btn btn-primary w-100 btn-sm" href="<?= e(url('product.php?id='.(int)$p['id'])) ?>">Lihat Produk</a></div>
  </article></div>
 <?php endwhile; else: ?><div class="col-12"><div class="empty-state">Produk belum ditemukan. Coba kata kunci lain.</div></div><?php endif; ?>
 </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
