<?php
// Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $result = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id = '$id'");
    $data = mysqli_fetch_assoc($result);
}

if (!$data) {
    echo "Data pesanan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pesanan #<?php echo $data['id']; ?></title>
    <style>
        body { font-family: monospace; padding: 20px; color: #333; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            font-size: 16px;
            line-height: 24px;
        }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; font-size: 14px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 120px; }
        .total { font-weight: bold; border-top: 1px solid #333; border-bottom: 1px solid #333; padding: 10px 0; margin-top: 10px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; font-style: italic; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="invoice-box">
    <div class="header">
        <h1>TOKO BOTOL PINTAR</h1>
        <p>Spesialis Smart Tumbler LED Terbaik</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">No. Pesanan</td>
            <td>: #<?php echo $data['id']; ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>: <?php echo date('d M Y H:i', strtotime($data['waktu_pesan'])); ?></td>
        </tr>
        <tr><td colspan="2"><br></td></tr>
        <tr>
            <td class="label">Nama Pembeli</td>
            <td>: <strong><?php echo htmlspecialchars($data['nama_pembeli']); ?></strong></td>
        </tr>
        <tr>
            <td class="label">Nomor HP</td>
            <td>: <?php echo $data['nomor_hp']; ?></td>
        </tr>
        <tr>
            <td class="label">Alamat Kirim</td>
            <td>: <?php echo nl2br(htmlspecialchars($data['alamat'])); ?></td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <p><strong>Rincian Barang:</strong></p>
        <p>1x Smart Tumbler LED Custom (Hitam/Putih)</p>
    </div>

    <table class="info-table" style="margin-top: 10px;">
        <tr>
            <td class="label">Harga Satuan</td>
            <td>: Rp 149.000</td>
        </tr>
        <tr>
            <td class="label">Ongkos Kirim</td>
            <td>: Rp 10.000</td>
        </tr>
    </table>

    <div class="total">
        TOTAL BAYAR: Rp 159.000
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Toko Botol Pintar!</p>
        <p>Simpan struk ini sebagai bukti pemesanan.</p>
    </div>
</div>

</body>
</html>
