<?php
session_start();
header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autorizado']);
    exit;
}

// Verificar si se recibió un ID de producto
if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de producto no proporcionado']);
    exit;
}

$productId = $_POST['product_id'];

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Simulación de verificación de stock (esto será reemplazado por la base de datos)
$products = [
    1 => ['stock' => 10],
    2 => ['stock' => 15],
    3 => ['stock' => 8],
    4 => ['stock' => 20],
    5 => ['stock' => 25]
];

// Verificar si el producto existe y tiene stock
if (!isset($products[$productId])) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    exit;
}

// Verificar stock
$currentQuantity = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 0;
if ($currentQuantity >= $products[$productId]['stock']) {
    echo json_encode(['success' => false, 'message' => 'No hay suficiente stock disponible']);
    exit;
}

// Agregar producto al carrito
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]++;
} else {
    $_SESSION['cart'][$productId] = 1;
}

echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']); 