CREATE DATABASE IF NOT EXISTS toko_simpel;
USE toko_simpel;

CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pembeli VARCHAR(100),
    nomor_hp VARCHAR(20),
    alamat TEXT,
    warna VARCHAR(20),
    waktu_pesan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
