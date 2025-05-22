<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Verificar si se proporcionó un ID de producto
if (!isset($_GET['id'])) {
    header('Location: index.php?acc=Products');
    exit;
}

$productId = $_GET['id'];

// Simulación de productos (reemplazar por la base de datos)
$products = [
    1 => [
        'name' => 'Laptop Gaming Pro',
        'price' => 1299.99,
        'stock' => 10,
        'image' => 'assets/images/laptop.jpg',
        'description' => 'Potente laptop para gaming con las últimas especificaciones.',
        'specs' => [
            'Procesador' => 'Intel Core i9 12th Gen',
            'RAM' => '32GB DDR5',
            'Almacenamiento' => '1TB SSD NVMe',
            'Tarjeta Gráfica' => 'NVIDIA RTX 3080 16GB',
            'Pantalla' => '17.3" 4K 144Hz',
            'Sistema Operativo' => 'Windows 11 Pro'
        ]
    ],
    2 => [
        'name' => 'Smartphone Ultra',
        'price' => 899.99,
        'stock' => 15,
        'image' => 'assets/images/phone.jpg',
        'description' => 'Smartphone de última generación con cámara de alta resolución.',
        'specs' => [
            'Procesador' => 'Snapdragon 8 Gen 2',
            'RAM' => '12GB LPDDR5X',
            'Almacenamiento' => '256GB UFS 4.0',
            'Pantalla' => '6.7" AMOLED 2K 120Hz',
            'Cámara Principal' => '200MP + 50MP + 12MP',
            'Batería' => '5000mAh con carga rápida de 100W'
        ]
    ],
    3 => [
        'name' => 'Monitor 4K',
        'price' => 499.99,
        'stock' => 8,
        'image' => 'assets/images/monitor.jpg',
        'description' => 'Monitor 4K con tecnología HDR y alta frecuencia de actualización.',
        'specs' => [
            'Tamaño' => '32"',
            'Resolución' => '3840 x 2160 (4K)',
            'Tipo de Panel' => 'IPS',
            'Tasa de Refresco' => '144Hz',
            'Tiempo de Respuesta' => '1ms',
            'HDR' => 'HDR600'
        ]
    ],
    4 => [
        'name' => 'Teclado Mecánico RGB',
        'price' => 129.99,
        'stock' => 20,
        'image' => 'assets/images/keyboard.jpg',
        'description' => 'Teclado mecánico con retroiluminación RGB y switches Cherry MX.',
        'specs' => [
            'Tipo' => 'Mecánico',
            'Switches' => 'Cherry MX Red',
            'Iluminación' => 'RGB personalizable',
            'Conexión' => 'USB-C desmontable',
            'Material' => 'Aluminio y PBT',
            'Anti-ghosting' => 'N-Key Rollover'
        ]
    ],
    5 => [
        'name' => 'Mouse Gaming',
        'price' => 79.99,
        'stock' => 25,
        'image' => 'assets/images/mouse.jpg',
        'description' => 'Mouse gaming con sensor de alta precisión y botones programables.',
        'specs' => [
            'Sensor' => 'Optical 25,600 DPI',
            'Botones' => '8 programables',
            'Iluminación' => 'RGB personalizable',
            'Conexión' => 'USB 2.0',
            'Peso' => 'Ajustable (80-120g)',
            'Tasa de Respuesta' => '1ms'
        ]
    ]
];

// Verificar si el producto existe
if (!isset($products[$productId])) {
    header('Location: index.php?acc=Products');
    exit;
}

$product = $products[$productId];

require_once("./views/product_details/vProductDetails.php");
?>