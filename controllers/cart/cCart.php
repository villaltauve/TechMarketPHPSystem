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

// Simulación de productos (reemplazar por la base de datos)
$products = [
    1 => ['name' => 'Laptop Gaming Pro', 'price' => 1299.99],
    2 => ['name' => 'Smartphone Ultra', 'price' => 899.99],
    3 => ['name' => 'Monitor 4K', 'price' => 499.99],
    4 => ['name' => 'Teclado Mecánico RGB', 'price' => 129.99],
    5 => ['name' => 'Mouse Gaming', 'price' => 79.99]
];

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $productId = $_POST['product_id'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

// Calcular total
$total = 0;
foreach ($_SESSION['cart'] as $productId => $quantity) {
    if (isset($products[$productId])) {
        $total += $products[$productId]['price'] * $quantity;
    }
}

require_once("./views/cart/vCart.php");
?>