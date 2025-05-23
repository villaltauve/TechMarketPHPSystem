<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Incluir archivos necesarios
require_once './config/database.php';
require_once './models/Product.php';

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once("./views/products/vProducts.php");
?>