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
        echo "<script>alert('Pesanan Berhasil! Mohon tunggu, Admin akan menghubungi Anda via WhatsApp untuk konfirmasi pembayaran.'); window.location='index.php';</script>";
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
    <title>Smart Tumbler LED - Toko Botol Pintar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-color: #ff6b6b;
            --text-dark: #2d3436;
            --text-light: #636e72;
            --white: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--primary-gradient);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-wrapper {
            background: var(--white);
            max-width: 900px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
        }

        /* Left Side - Product Image & Info */
        .product-section {
            flex: 1;
            padding: 40px;
            background: #f8f9fa;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .product-img {
            width: 100%;
            max-width: 300px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .product-img:hover {
            transform: scale(1.05);
        }

        .price-tag {
            background: var(--accent-color);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }

        .features {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 20px;
        }

        .features li {
            margin-bottom: 10px;
            color: var(--text-light);
            font-size: 14px;
        }

        .features i {
            color: #2ecc71;
            margin-right: 8px;
        }

        /* Right Side - Checkout Form */
        .form-section {
            flex: 1;
            padding: 40px;
            min-width: 300px;
        }

        h1 {
            color: var(--text-dark);
            font-size: 28px;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 30px;
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #dfe6e9;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #6c5ce7;
        }

        textarea {
            padding-left: 15px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 15px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(108, 92, 231, 0.3);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(108, 92, 231, 0.4);
        }

        .secure-badge {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #b2bec3;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }
            .product-section {
                padding-bottom: 0;
            }
            .product-img {
                max-width: 200px;
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Kolom Produk -->
    <div class="product-section">
        <img src="produk.png" alt="Smart Tumbler" class="product-img">
        <div class="price-tag">Rp 149.000</div>
        
        <ul class="features">
            <li><i class="fas fa-check-circle"></i> Layar LED Suhu Real-time</li>
            <li><i class="fas fa-check-circle"></i> Tahan Panas/Dingin 12 Jam</li>
            <li><i class="fas fa-check-circle"></i> Material Stainless Steel 304</li>
            <li><i class="fas fa-check-circle"></i> Baterai Tahan Lama (500 hari)</li>
        </ul>
    </div>

    <!-- Kolom Form -->
    <div class="form-section">
        <h1>Form Pemesanan</h1>
        <span class="subtitle">Isi data di bawah ini, Admin kami akan segera menghubungi Anda.</span>

        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama_pembeli" placeholder="Nama Anda..." required>
                </div>
            </div>

            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <div class="input-group">
                    <i class="fab fa-whatsapp"></i>
                    <input type="number" name="nomor_hp" placeholder="Contoh: 0812..." required>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Pengiriman</label>
                <textarea name="alamat" rows="3" placeholder="Jalan, No. Rumah, Kecamatan, Kota..." required></textarea>
            </div>

            <button type="submit" name="submit_pesan">
                <i class="fas fa-shopping-cart"></i> PESAN SEKARANG
            </button>
        </form>

        <div class="secure-badge">
            <span><i class="fas fa-shield-alt"></i> Data Aman</span>
            <span><i class="fas fa-shipping-fast"></i> Proses Cepat</span>
        </div>
    </div>
</div>

</body>
</html>
