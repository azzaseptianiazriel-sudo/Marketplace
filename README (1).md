# MarketKita — Marketplace PHP Native

Aplikasi marketplace sederhana sesuai Soal 11, menggunakan PHP Native, MySQLi, MySQL, dan Bootstrap 5.

## Fitur
- Satu halaman login untuk Admin dan Pembeli; sistem mengarahkan sesuai role.
- Registrasi Pembeli.
- Katalog produk dengan foto, pencarian, dan kategori.
- Detail produk.
- Keranjang belanja berbasis session.
- Checkout dan penyimpanan transaksi dengan transaksi database.
- Admin: dashboard, CRUD produk, kategori, data pengguna, dan pengelolaan status pesanan.

## Instalasi XAMPP
1. Ekstrak folder `marketkita` ke `C:\xampp\htdocs\marketkita` (atau folder htdocs XAMPP yang digunakan).
2. Jalankan Apache dan MySQL.
3. Buka phpMyAdmin, buat/import database dengan mengimpor `database.sql`. File SQL membuat database `marketkita`.
4. Periksa `config.php`: host `localhost`, user `root`, password kosong, database `marketkita`. Sesuaikan `BASE_URL` jika folder memiliki nama berbeda.
5. Buka `http://localhost/marketkita/setup.php` satu kali untuk membuat akun demo.
6. Setelah muncul pesan berhasil, HAPUS `setup.php`.
7. Buka `http://localhost/marketkita/`.

## Akun demo
- Admin: `admin@marketkita.test` / `admin123`
- Pembeli: `pembeli@marketkita.test` / `pembeli123`

Ganti password demo sebelum aplikasi dipublikasikan.

## Catatan gambar
Foto produk contoh menggunakan URL gambar Unsplash. Koneksi internet diperlukan agar foto tampil. Admin dapat mengganti URL gambar melalui menu Kelola Produk.

## Deployment InfinityFree
- Buat database MySQL dari panel hosting.
- Impor `database.sql` melalui phpMyAdmin hosting (jika database sudah dibuat panel, hapus baris CREATE DATABASE/USE bila diperlukan).
- Sesuaikan `config.php` memakai hostname, username, password, dan nama database dari panel InfinityFree.
- Ubah `BASE_URL` menjadi string kosong jika aplikasi berada langsung di `htdocs`/`htdocs`-equivalent domain root, atau sesuaikan subfolder.
- Upload seluruh isi folder ke `htdocs` hosting.
- Jalankan `setup.php` satu kali, lalu hapus file tersebut.
- Jangan commit password database atau file konfigurasi berisi kredensial ke repository publik.

## Entitas dan relasi
1. users: akun admin dan pembeli.
2. categories: kategori produk.
3. products: data barang.
4. orders: header transaksi.
5. order_items: rincian barang tiap transaksi.

Relasi:
- categories 1—N products.
- users 1—N orders.
- orders 1—N order_items.
- products 1—N order_items (referensi produk boleh NULL bila produk dihapus; snapshot nama dan harga tetap tersimpan).

## Alur transaksi
Pembeli membuka katalog → melihat detail → menambahkan produk ke keranjang → login/registrasi → checkout mengisi alamat dan telepon → sistem memvalidasi stok → menyimpan orders dan order_items dalam satu transaksi database → stok dikurangi → pembeli melihat riwayat pesanan.

## Pengujian minimum
1. Login admin dan pastikan diarahkan ke dashboard admin.
2. Login pembeli dan pastikan diarahkan ke katalog.
3. Admin tambah, edit, dan hapus produk.
4. Pembeli menambahkan produk ke keranjang.
5. Pembeli checkout dan pastikan orders serta order_items bertambah.
6. Pastikan stok produk berkurang sesuai jumlah pesanan.
7. Admin mengubah status pesanan.

## Laporan
Dokumen rancangan ERD, alur transaksi, mockup konseptual, screenshot aplikasi, screenshot database, hasil pengujian, URL demo, dan URL GitHub dapat dilengkapi setelah deployment.
