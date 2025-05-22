<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Simulación de productos en stock (esto será reemplazado por la base de datos)
$products = [
    [
        'id' => 1,
        'name' => 'Laptop Gaming Pro',
        'price' => 1299.99,
        'stock' => 10,
        'image' => 'assets/images/laptop.jpg',
        'description' => 'Potente laptop para gaming con las últimas especificaciones.'
    ],
    [
        'id' => 2,
        'name' => 'Smartphone Ultra',
        'price' => 899.99,
        'stock' => 15,
        'image' => 'assets/images/phone.jpg',
        'description' => 'Smartphone de última generación con cámara de alta resolución.'
    ],
    [   
        'id' => 3,
        'name' => 'Monitor 4K',
        'price' => 499.99,
        'stock' => 8,
        'image' => 'assets/images/monitor.jpg',
        'description' => 'Monitor 4K con tecnología HDR y alta frecuencia de actualización.'
    ],
    [
        'id' => 4,
        'name' => 'Teclado Mecánico RGB',
        'price' => 129.99,
        'stock' => 20,
        'image' => 'assets/images/keyboard.jpg',
        'description' => 'Teclado mecánico con retroiluminación RGB y switches Cherry MX.'
    ],
    [
        'id' => 5,
        'name' => 'Mouse Gaming',
        'price' => 79.99,
        'stock' => 25,
        'image' => 'assets/images/mouse.jpg',
        'description' => 'Mouse gaming con sensor de alta precisión y botones programables.'
    ]
];

require_once("./views/products/vProducts.php");
?>