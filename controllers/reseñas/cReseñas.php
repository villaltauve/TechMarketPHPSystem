<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Incluir archivos necesarios
require_once './config/database.php';
require_once './models/Product.php';
require_once './models/Reseña.php';

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$ReseñasModel = new Reseñas($db);

$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$reseñas = $ReseñasModel->obtenerResenasConProductoYUsuario();

require_once("./views/reseñas/vReseñas.php");
?>