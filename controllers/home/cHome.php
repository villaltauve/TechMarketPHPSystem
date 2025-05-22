<?php
session_start();

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin123' && $password === 'pass123') {
        $_SESSION['logged_in'] = true;
        $isLoggedIn = true;
    }
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    $isLoggedIn = false;
}
// Aquí mostraremos los productos destacados
$featuredProducts = [
    [
        'id' => 1,
        'name' => 'Laptop Gaming Pro',
        'price' => 1299.99,
        'image' => 'assets/images/laptop.jpg',
        'description' => 'Potente laptop para gaming con las últimas especificaciones.'
    ],
    [
        'id' => 2,
        'name' => 'Smartphone Ultra',
        'price' => 899.99,
        'image' => 'assets/images/phone.jpg',
        'description' => 'Smartphone de última generación con cámara de alta resolución.'
    ],
    [
        'id' => 3,
        'name' => 'Monitor 4K',
        'price' => 499.99,
        'image' => 'assets/images/monitor.jpg',
        'description' => 'Monitor 4K con tecnología HDR y alta frecuencia de actualización.'
    ]
];

require_once("./views/home/vHome.php");

?>