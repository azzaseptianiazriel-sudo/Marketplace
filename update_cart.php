<?php
require_once __DIR__.'/includes/functions.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){redirect('cart.php');}
verify_csrf();
foreach(($_POST['qty']??[]) as $id=>$qty){$id=(int)$id;$qty=(int)$qty;if($qty<=0){unset($_SESSION['cart'][$id]);}else{$_SESSION['cart'][$id]=min($qty,99);}}
set_flash('Keranjang berhasil diperbarui.');redirect('cart.php');
