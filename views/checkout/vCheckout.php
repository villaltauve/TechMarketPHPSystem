<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
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
                                        <p>Subtotal:
                                            $<?php echo number_format($products[$productId]['price'] * $quantity, 2); ?></p>
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
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>