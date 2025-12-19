<?php
// Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Logika saat tombol ditekan
if (isset($_POST['submit_pesan'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $hp     = mysqli_real_escape_string($koneksi, $_POST['nomor_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $simpan = mysqli_query($koneksi, "INSERT INTO pesanan (nama_pembeli, nomor_hp, alamat) VALUES ('$nama', '$hp', '$alamat')");
    
    if ($simpan) {
        echo "<script>alert('Pesanan Anda Berhasil Dicatat!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan pesanan: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jual Smart Tumbler LED</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; background: #f9f9f9; }
        .header { background: #333; color: white; text-align: center; padding: 10px; }
        .container { max-width: 600px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        img { width: 100%; border-radius: 10px; }
        .harga { color: #e74c3c; font-size: 24px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { background: #27ae60; color: white; padding: 15px; width: 100%; border: none; cursor: pointer; font-weight: bold; font-size: 16px; }
        button:hover { background: #219150; }
        .footer { text-align: center; margin-top: 20px; color: #777; font-size: 12px; }
    </style>
</head>
<body>

<div class="header"><h1>Toko Botol Pintar</h1></div>

<div class="container">
    <img src="produk.png" alt="Smart Tumbler">
    <h2>Smart LED Temperature Tumbler</h2>
    <p class="harga">Rp 149.000</p>
    <p>Botol minum canggih yang bisa menunjukkan suhu air. Material premium dan tahan panas lama. Cocok untuk menemani aktivitas harianmu.</p>
    
    <hr>
    <h3>Isi Data Untuk Memesan:</h3>
    <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_pembeli" placeholder="Contoh: Budi Santoso" required>
        
        <label>Nomor WhatsApp</label>
        <input type="number" name="nomor_hp" placeholder="Contoh: 081234567890" required>
        
        <label>Alamat Pengiriman</label>
        <textarea name="alamat" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos" rows="4" required></textarea>
        
        <button type="submit" name="submit_pesan">PESAN SEKARANG</button>
    </form>
</div>

<div class="footer">
    &copy; <?php echo date("Y"); ?> Toko Botol Pintar. All rights reserved.
</div>

</body>
</html>
