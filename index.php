<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMarket - Tu Tienda de Tecnología</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
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
    ?>

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
        <?php if (!$isLoggedIn): ?>
            <div class="login-container">
                <h2>Iniciar Sesión</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Usuario:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login">Ingresar</button>
                </form>
            </div>
        <?php endif; ?>

        <section class="featured-products">
            <h2>Productos Destacados</h2>
            <div class="products-grid">
                <?php
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

                foreach ($featuredProducts as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <p class="description"><?php echo $product['description']; ?></p>
                        <?php if ($isLoggedIn): ?>
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