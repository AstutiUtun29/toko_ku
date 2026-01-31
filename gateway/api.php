<?php
// API Gateway Logic  
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$koneksi = mysqli_connect("localhost", "root", "", "toko_simpel");

if (mysqli_connect_errno()) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

switch ($endpoint) {
    case 'orders':
        if (isset($_GET['id'])) {
            $id = mysqli_real_escape_string($koneksi, $_GET['id']);
            $query = "SELECT * FROM pesanan WHERE id = '$id'";
        } else {
            $query = "SELECT * FROM pesanan ORDER BY waktu_pesan DESC";
        }
        
        $result = mysqli_query($koneksi, $query);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        echo json_encode(["status" => "success", "data" => $data], JSON_PRETTY_PRINT);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid endpoint. Use ?endpoint=orders"]);
        break;
}
?>
