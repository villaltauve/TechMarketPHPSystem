<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o el carrito está vacío
if (!$isLoggedIn || empty($_SESSION['cart'])) {
    header('Location: index.php?acc=Home');
    exit;
}

// Simulación de productos (reemplazar por la base de datos)
$products = [
    1 => ['name' => 'Laptop Gaming Pro', 'price' => 1299.99],
    2 => ['name' => 'Smartphone Ultra', 'price' => 899.99],
    3 => ['name' => 'Monitor 4K', 'price' => 499.99],
    4 => ['name' => 'Teclado Mecánico RGB', 'price' => 129.99],
    5 => ['name' => 'Mouse Gaming', 'price' => 79.99]
];

// Calcular total
$total = 0;
foreach ($_SESSION['cart'] as $productId => $quantity) {
    if (isset($products[$productId])) {
        $total += $products[$productId]['price'] * $quantity;
    }
}

// Procesar el formulario de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if ($name && $phone && $email) {
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
            'items' => $_SESSION['cart'],
            'total' => $total
        ];
        
        // Redirigir a la página de factura
        header('Location: index.php?acc=Invoice');
        exit;
    }
}
require_once("./views/checkout/vCheckout.php");
?>
