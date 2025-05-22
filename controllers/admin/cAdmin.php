<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado
if (!$isLoggedIn) {
    header('Location: index.php?acc=Home');
    exit;
}

// Simulación de productos (reemplazar por la base de datos)
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
    ]
];

// Procesar el formulario de nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Aquí se procesaría la adición del nuevo producto
        $newProduct = [
            'id' => count($products) + 1,
            'name' => $_POST['name'],
            'price' => floatval($_POST['price']),
            'stock' => intval($_POST['stock']),
            'image' => 'assets/images/default.jpg', // imagenor defecto
            'description' => $_POST['description']
        ];
        
        // Procesar la imagen si se subió una
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/images/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $newProduct['image'] = $uploadFile;
            }
        }
        
        $products[] = $newProduct;
    }
}

require_once("./views/admin/vAdmin.php");
?>