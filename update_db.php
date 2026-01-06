<?php
// Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "<h1>Auto Update Database</h1>";

// Cek apakah kolom warna sudah ada
$check = mysqli_query($koneksi, "SHOW COLUMNS FROM pesanan LIKE 'warna'");

if (mysqli_num_rows($check) == 0) {
    // Jika belum ada, tambahkan
    $update = mysqli_query($koneksi, "ALTER TABLE pesanan ADD COLUMN warna VARCHAR(20) AFTER alamat");
    
    if ($update) {
        echo "<h3 style='color: green;'>BERHASIL! Kolom 'warna' berhasil ditambahkan.</h3>";
        echo "<p>Sekarang sistem sudah siap mencatat warna pilihan pembeli.</p>";
    } else {
        echo "<h3 style='color: red;'>GAGAL: " . mysqli_error($koneksi) . "</h3>";
    }
} else {
    echo "<h3 style='color: blue;'>INFO: Kolom 'warna' sudah ada. Tidak perlu update.</h3>";
}

echo "<br><br><a href='index.php'>Kembali ke Toko</a>";
?>
