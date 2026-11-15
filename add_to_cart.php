<?php
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/functions.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){redirect('index.php');}
verify_csrf();
$id=(int)($_POST['id']??0);$qty=max(1,(int)($_POST['qty']??1));
$stmt=$conn->prepare("SELECT id,stock FROM products WHERE id=? AND is_active=1");$stmt->bind_param('i',$id);$stmt->execute();$p=$stmt->get_result()->fetch_assoc();
if(!$p){set_flash('Produk tidak tersedia.','danger');redirect('index.php');}
$existing=(int)($_SESSION['cart'][$id]??0);
if($existing+$qty>(int)$p['stock']){set_flash('Jumlah melebihi stok yang tersedia.','warning');redirect('detail.php?id='.$id);}
$_SESSION['cart'][$id]=$existing+$qty;
set_flash('Produk berhasil ditambahkan ke keranjang.');
redirect('cart.php');
