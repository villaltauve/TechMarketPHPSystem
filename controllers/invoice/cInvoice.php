<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o no hay factura
if (!$isLoggedIn || !isset($_SESSION['invoice'])) {
    header('Location: index.php?acc=Home');
    exit;
}

$invoice = $_SESSION['invoice'];

// Simulación de productos (esto será reemplazado por la base de datos)
$products = [
    1 => ['name' => 'Laptop Gaming Pro', 'price' => 1299.99],
    2 => ['name' => 'Smartphone Ultra', 'price' => 899.99],
    3 => ['name' => 'Monitor 4K', 'price' => 499.99],
    4 => ['name' => 'Teclado Mecánico RGB', 'price' => 129.99],
    5 => ['name' => 'Mouse Gaming', 'price' => 79.99]
];

require_once("./views/invoice/vInvoice.php");
?>
