<?php
session_start();

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Incluir archivos necesarios
require_once './config/database.php';
require_once './models/Product.php';

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin123' && $password === 'pass123') {
        $_SESSION['logged_in'] = true;
        $isLoggedIn = true;
    }
}

// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();


$product = new Product($db);

$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    $isLoggedIn = false;
}


require_once("./views/home/vHome.php");

?>