<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Verificar si se proporcionó un ID de producto
if (!isset($_GET['id'])) {
    header('Location: products.php');
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
    header('Location: products.php');
    exit;
}

$product = $products[$productId];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .product-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .product-info {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .product-info h1 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 1rem 0;
        }

        .product-stock {
            color: #28a745;
            margin-bottom: 1rem;
        }

        .product-description {
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .product-specs {
            margin-top: 2rem;
        }

        .product-specs h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .spec-item {
            background-color: var(--background-color);
            padding: 1rem;
            border-radius: 4px;
        }

        .spec-item strong {
            display: block;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .product-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">TechMarket</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="products.php">Productos</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="cart.php">Carrito</a></li>
                    <li><a href="admin.php">Administrar</a></li>
                    <li><a href="?logout=1">Cerrar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="product-details">
            <div class="product-image-container">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
            </div>
            
            <div class="product-info">
                <h1><?php echo $product['name']; ?></h1>
                <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="product-stock">Stock disponible: <?php echo $product['stock']; ?></p>
                <p class="product-description"><?php echo $product['description']; ?></p>
                
                <?php if ($isLoggedIn && $product['stock'] > 0): ?>
                    <button class="add-to-cart" data-product-id="<?php echo $productId; ?>">Agregar al Carrito</button>
                <?php endif; ?>
                
                <div class="product-specs">
                    <h3>Especificaciones Técnicas</h3>
                    <div class="specs-grid">
                        <?php foreach ($product['specs'] as $spec => $value): ?>
                            <div class="spec-item">
                                <strong><?php echo $spec; ?></strong>
                                <span><?php echo $value; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 