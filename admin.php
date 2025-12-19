<?php
// Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY waktu_pesan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Pesanan</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #f0f2f5; }
        .header { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        h1 { margin: 0; font-size: 24px; color: #333; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        th, td { text-align: left; padding: 12px 15px; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #555; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        tr:hover { background-color: #f1f1f1; }
        .badge { background: #27ae60; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; }
        .empty { text-align: center; padding: 40px; color: #777; font-style: italic; }
        .btn-refresh { text-decoration: none; background: #3498db; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
        .btn-refresh:hover { background: #2980b9; }
    </style>
</head>
<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <a href="admin.php" class="btn-refresh">Refresh Data</a>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Pembeli</th>
                <th>Nomor HP</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($row['waktu_pesan'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($row['nama_pembeli']); ?></strong></td>
                    <td>
                        <a href="https://wa.me/<?php echo $row['nomor_hp']; ?>" target="_blank" style="color: #27ae60; text-decoration: none; font-weight: bold;">
                            <?php echo $row['nomor_hp']; ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">Belum ada pesanan masuk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
