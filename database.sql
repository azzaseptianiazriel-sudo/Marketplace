CREATE DATABASE IF NOT EXISTS marketkita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE marketkita;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(160) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','pembeli') NOT NULL DEFAULT 'pembeli',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id INT UNSIGNED NULL,
 name VARCHAR(180) NOT NULL,
 description TEXT,
 price DECIMAL(12,2) NOT NULL,
 stock INT UNSIGNED NOT NULL DEFAULT 0,
 image_url VARCHAR(500) NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_products_category FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE orders (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 total_amount DECIMAL(14,2) NOT NULL,
 status ENUM('menunggu','diproses','dikirim','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',
 shipping_address TEXT NOT NULL,
 phone VARCHAR(30) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_orders_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE order_items (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_id INT UNSIGNED NOT NULL,
 product_id INT UNSIGNED NULL,
 product_name VARCHAR(180) NOT NULL,
 price DECIMAL(12,2) NOT NULL,
 quantity INT UNSIGNED NOT NULL,
 subtotal DECIMAL(14,2) NOT NULL,
 CONSTRAINT fk_items_order FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT fk_items_product FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO categories(name) VALUES
('Bahan Pokok'),('Sayuran'),('Buah-buahan'),('Bumbu Dapur');

INSERT INTO products(category_id,name,description,price,stock,image_url) VALUES
(1,'Beras Premium 5 Kg','Beras pilihan pulen untuk kebutuhan keluarga.',72000,25,'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=900&auto=format&fit=crop&q=80'),
(2,'Cabai Merah 250 Gram','Cabai merah segar pilihan.',18000,40,'https://images.unsplash.com/photo-1588252303782-cb80119abd6d?w=900&auto=format&fit=crop&q=80'),
(3,'Pisang Kepok 1 Sisir','Pisang kepok matang pilihan.',28000,18,'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=900&auto=format&fit=crop&q=80'),
(2,'Tomat Segar 1 Kg','Tomat segar untuk masakan harian.',14000,30,'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=900&auto=format&fit=crop&q=80'),
(4,'Bawang Merah 500 Gram','Bawang merah segar berkualitas.',22000,35,'https://images.unsplash.com/photo-1508747703725-719777637510?w=900&auto=format&fit=crop&q=80'),
(3,'Jeruk Manis 1 Kg','Jeruk manis dan segar.',26000,20,'https://images.unsplash.com/photo-1547514701-42782101795e?w=900&auto=format&fit=crop&q=80');
