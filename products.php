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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
        <section class="products-section">
            <h2>Productos Disponibles</h2>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <p class="stock">Stock disponible: <?php echo $product['stock']; ?></p>
                        <p class="description"><?php echo $product['description']; ?></p>
                        <?php if ($isLoggedIn && $product['stock'] > 0): ?>
                            <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Agregar al Carrito</button>
                        <?php endif; ?>
                        <a href="product-details.php?id=<?php echo $product['id']; ?>" class="view-details">Ver Detalles</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 TechMarket. Todos los derechos reservados.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 