<?php
// Gateway Entry Point
header('Content-Type: application/json');

$response = [
    "status" => "online",
    "service" => "Toko Ku API Gateway",
    "version" => "1.0.0",
    "endpoints" => [
        "GET /gateway/api.php?endpoint=orders" => "Get all orders",
        "GET /gateway/api.php?endpoint=orders&id=1" => "Get specific order"
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
