<?php
session_start();
header('Content-Type: application/json');

// Verificar si se recibió un ID de producto
if (!isset($_GET['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de producto no proporcionado']);
    exit;
}

$productId = $_GET['product_id'];

// Incluir archivos necesarios
require_once './config/database.php';
require_once './models/Product.php';

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->id = $productId;
$productData = $product->readOne();

if (!$productData) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    exit;
}

// Calcular el stock actual
$currentQuantity = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 0;
$availableStock = $productData['stock'] - $currentQuantity;

echo json_encode([
    'success' => true,
    'stock' => $availableStock
]); 