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

// Incluir archivos necesarios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Product.php';

try {
    // Obtener conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $product->id = $productId;
    $productData = $product->readOne();

    // Verificar si el producto existe y tiene stock
    if (!$productData) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit;
    }

    // Verificar stock
    $currentQuantity = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 0;
    if ($currentQuantity >= $productData['stock']) {
        echo json_encode(['success' => false, 'message' => 'No hay suficiente stock disponible']);
        exit;
    }

    // Agregar producto al carrito
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }

    // Guardar el carrito en la sesión
    $_SESSION['cart'] = array_filter($_SESSION['cart']);

    echo json_encode([
        'success' => true, 
        'message' => 'Producto agregado al carrito',
        'cart' => $_SESSION['cart']
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} 