<?php
// Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Logika Hapus Satu Pesanan
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM pesanan WHERE id = '$id_hapus'");
    echo "<script>alert('Data pesanan berhasil dihapus!'); window.location='admin.php';</script>";
}

// Logika Hapus Semua Pesanan
if (isset($_GET['hapus_semua'])) {
    mysqli_query($koneksi, "TRUNCATE TABLE pesanan");
    echo "<script>alert('Semua riwayat pesanan berhasil dihapus!'); window.location='admin.php';</script>";
}

$result = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY waktu_pesan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Botol Pintar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f39c12;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-bg: #f4f7f6;
            --white: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px 20px;
            min-height: 100vh;
            color: var(--dark-color);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .btn-refresh { background-color: var(--primary-color); }
        .btn-refresh:hover { background-color: #357abd; }

        .btn-delete-all { background-color: var(--danger-color); }
        .btn-delete-all:hover { background-color: #c0392b; }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 700px;
        }

        th {
            background-color: #f8f9fa;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            padding: 18px 20px;
            text-align: left;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover td {
            background-color: #fbfbfb;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: all 0.2s;
            margin-right: 5px;
        }

        .btn-wa { background: #2ecc71; }
        .btn-wa:hover { background: #27ae60; transform: scale(1.1); }

        .btn-print { background: #f1c40f; }
        .btn-print:hover { background: #f39c12; transform: scale(1.1); }

        .btn-resi { background: #3498db; }
        .btn-resi:hover { background: #2980b9; transform: scale(1.1); }

        .btn-del { background: #e74c3c; }
        .btn-del:hover { background: #c0392b; transform: scale(1.1); }

        .customer-name { font-weight: 600; color: var(--dark-color); }
        .customer-phone { color: var(--primary-color); font-weight: 500; }
        .date-info { color: #95a5a6; font-size: 13px; }

        .empty-state { text-align: center; padding: 60px 20px; color: #95a5a6; }
        .empty-state i { font-size: 48px; margin-bottom: 20px; color: #ddd; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="fas fa-boxes"></i> Pesanan Masuk</h1>
        <div class="header-actions">
            <a href="admin.php?hapus_semua=true" class="btn btn-delete-all" onclick="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SEMUA riwayat pesanan? Data yang dihapus tidak bisa dikembalikan!');">
                <i class="fas fa-trash"></i> Hapus Semua
            </a>
            <button onclick="window.location.reload();" class="btn btn-refresh">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Nama Pembeli</th>
                    <th width="15%">Nomor HP</th>
                    <th width="25%">Alamat</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        // Format Nomor HP (08... -> 628...)
                        $nomor_hp = preg_replace('/[^0-9]/', '', $row['nomor_hp']); 
                        if (substr($nomor_hp, 0, 1) == '0') {
                            $nomor_hp = '62' . substr($nomor_hp, 1);
                        }

                        // Template pesan untuk Admin
                        $pesan_admin = "Halo " . $row['nama_pembeli'] . ", terima kasih sudah memesan di Toko Botol Pintar.\n\n" . 
                                       "Berikut rincian pesanan kakak:\n" .
                                       "Item: 1x Smart Tumbler LED\n" .
                                       "Alamat: " . $row['alamat'] . "\n\n" .
                                       "Rincian Biaya:\n" .
                                       "- Harga: Rp 149.000\n" .
                                       "- Ongkir: Rp 10.000\n" .
                                       "*Total: Rp 159.000*\n\n" . 
                                       "Silakan transfer ke BCA 123456789 a.n Toko Botol untuk diproses hari ini ya kak. Terima kasih!";
                        $link_konfirmasi = "https://wa.me/" . $nomor_hp . "?text=" . urlencode($pesan_admin);
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><div class="date-info"><?php echo date('d M Y H:i', strtotime($row['waktu_pesan'])); ?></div></td>
                        <td><div class="customer-name"><?php echo htmlspecialchars($row['nama_pembeli']); ?></div></td>
                        <td><div class="customer-phone"><?php echo $row['nomor_hp']; ?></div></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td>
                            <a href="cetak.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn-action btn-print" title="Cetak Pesanan">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="<?php echo $link_konfirmasi; ?>" target="_blank" class="btn-action btn-wa" title="Hubungi Pembeli">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" onclick="kirimResi('<?php echo $nomor_hp; ?>', '<?php echo addslashes($row['nama_pembeli']); ?>'); return false;" class="btn-action btn-resi" title="Kirim Resi">
                                <i class="fas fa-truck"></i>
                            </a>
                            <a href="admin.php?hapus=<?php echo $row['id']; ?>" class="btn-action btn-del" title="Hapus Pesanan" onclick="return confirm('Yakin ingin menghapus pesanan atas nama <?php echo htmlspecialchars($row['nama_pembeli']); ?>?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="far fa-folder-open"></i>
                            <p>Belum ada pesanan yang masuk hari ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function kirimResi(nomorHp, nama) {
        var resi = prompt("Masukkan Nomor Resi untuk " + nama + ":");
        if (resi != null && resi != "") {
            var pesan = "Halo " + nama + ", pesanan kakak sudah kami kirim ya.\n\n" +
                        "Berikut nomor resinya: *" + resi + "*\n\n" +
                        "Ditunggu barangnya sampai ya kak. Terima kasih!";
            var link = "https://wa.me/" + nomorHp + "?text=" + encodeURIComponent(pesan);
            window.open(link, '_blank');
        }
    }
</script>

</body>
</html>
