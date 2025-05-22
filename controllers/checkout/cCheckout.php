<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o el carrito está vacío
if (!$isLoggedIn || empty($_SESSION['cart'])) {
    header('Location: index.php?acc=Home');
    exit;
}

// Incluir archivos necesarios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Product.php';

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Obtener información de los productos en el carrito
$cartProducts = [];
$total = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product->id = $productId;
    $productData = $product->readOne();
    
    if ($productData) {
        $cartProducts[$productId] = [
            'id' => $productData['id'],
            'name' => $productData['name'],
            'price' => $productData['price'],
            'quantity' => $quantity,
            'stock' => $productData['stock']
        ];
        $total += $productData['price'] * $quantity;
    }
}

// Procesar el formulario de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if ($name && $phone && $email) {
        // Actualizar el stock de los productos
        foreach ($cartProducts as $productId => $item) {
            $product->id = $productId;
            $product->stock = $item['stock'] - $item['quantity'];
            $product->update();
        }

        // Generar número de factura
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Guardar datos de la factura en sesión
        $_SESSION['invoice'] = [
            'number' => $invoiceNumber,
            'date' => date('Y-m-d H:i:s'),
            'customer' => [
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ],
            'items' => $cartProducts,
            'total' => $total
        ];
        
        // Limpiar el carrito
        $_SESSION['cart'] = [];
        
        // Redirigir a la página de factura
        header('Location: index.php?acc=Invoice');
        exit;
    }
}

require_once("./views/checkout/vCheckout.php");
?>
