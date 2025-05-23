<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado
if (!$isLoggedIn) {
    header('Location: index.php?acc=Home');
    exit;
}

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Incluir archivos necesarios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Product.php';

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove']) && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        
        // Debug: Imprimir información
        error_log("Intentando eliminar producto ID: " . $productId);
        error_log("Carrito antes: " . print_r($_SESSION['cart'], true));
        
        // Verificar si el producto existe en el carrito
        if (isset($_SESSION['cart'][$productId])) {
            // Eliminar el producto del carrito
            unset($_SESSION['cart'][$productId]);
            
            // Debug: Imprimir información
            error_log("Carrito después: " . print_r($_SESSION['cart'], true));
            
            // Guardar los cambios en la sesión
            $_SESSION['cart'] = array_filter($_SESSION['cart']);
            
            // Forzar la escritura de la sesión
            session_write_close();
            
            // Redirigir para evitar reenvío del formulario
            header('Location: index.php?acc=Cart');
            exit;
        }
    }
}

// Obtener información de los productos en el carrito
$cartProducts = [];
$total = 0;

// Debug: Imprimir información del carrito
error_log("Carrito actual: " . print_r($_SESSION['cart'], true));

// Obtener información actualizada de los productos
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product->id = $productId;
    $productData = $product->readOne();
    
    if ($productData) {
        $cartProducts[$productId] = [
            'name' => $productData['name'],
            'price' => $productData['price'],
            'quantity' => $quantity
        ];
        $total += $productData['price'] * $quantity;
    } else {
        // Si el producto ya no existe, eliminarlo del carrito
        unset($_SESSION['cart'][$productId]);
    }
}

// Debug: Imprimir información de los productos
error_log("Productos en carrito: " . print_r($cartProducts, true));

require_once("./views/cart/vCart.php");
?>