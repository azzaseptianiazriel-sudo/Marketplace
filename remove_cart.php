<?php
require_once __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);$token=$_GET['token']??'';
if(!hash_equals(csrf_token(),(string)$token)){http_response_code(419);exit('Permintaan tidak valid.');}
unset($_SESSION['cart'][$id]);set_flash('Produk dihapus dari keranjang.');redirect('cart.php');
