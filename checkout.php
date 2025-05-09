<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o el carrito está vacío
if (!$isLoggedIn || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// Simulación de productos (esto será reemplazado por la base de datos)
$products = [
    1 => ['name' => 'Laptop Gaming Pro', 'price' => 1299.99],
    2 => ['name' => 'Smartphone Ultra', 'price' => 899.99],
    3 => ['name' => 'Monitor 4K', 'price' => 499.99],
    4 => ['name' => 'Teclado Mecánico RGB', 'price' => 129.99],
    5 => ['name' => 'Mouse Gaming', 'price' => 79.99]
];

// Calcular total
$total = 0;
foreach ($_SESSION['cart'] as $productId => $quantity) {
    if (isset($products[$productId])) {
        $total += $products[$productId]['price'] * $quantity;
    }
}

// Procesar el formulario de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if ($name && $phone && $email) {
        // Generar número de factura
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Guardar datos de la factura en sesión
        $_SESSION['invoice'] = [
            'number' => $invoiceNumber,
            'date' => date('Y-m-d H:i:s'),
            'customer' => [
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ],
            'items' => $_SESSION['cart'],
            'total' => $total
        ];
        
        // Redirigir a la página de factura
        header('Location: invoice.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">TechMarket</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="products.php">Productos</a></li>
                <li><a href="cart.php">Carrito</a></li>
                <li><a href="admin.php">Administrar</a></li>
                <li><a href="?logout=1">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="checkout-section">
            <h2>Información de Pago</h2>
            <div class="checkout-container">
                <div class="order-summary">
                    <h3>Resumen del Pedido</h3>
                    <div class="cart-items">
                        <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
                            <?php if (isset($products[$productId])): ?>
                                <div class="cart-item">
                                    <div class="item-details">
                                        <h4><?php echo $products[$productId]['name']; ?></h4>
                                        <p>Cantidad: <?php echo $quantity; ?></p>
                                        <p>Subtotal: $<?php echo number_format($products[$productId]['price'] * $quantity, 2); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="total">
                        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
                    </div>
                </div>

                <form method="POST" class="checkout-form">
                    <div class="form-group">
                        <label for="name">Nombre Completo:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" class="checkout-button">Realizar Pago</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 TechMarket. Todos los derechos reservados.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 