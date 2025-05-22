<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Verificar si se proporcionó un ID de producto
if (!isset($_GET['id'])) {
    header('Location: index.php?acc=Products');
    exit;
}

$productId = $_GET['id'];

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
    header('Location: index.php?acc=Products');
    exit;
}

$product = $productData;

require_once("./views/product_details/vProductDetails.php");
?>