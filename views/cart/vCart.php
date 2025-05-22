<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
    <main>
        <section class="cart-section">
            <h2>Carrito de Compras</h2>
            <?php if (empty($_SESSION['cart'])): ?>
                <p class="empty-cart">Tu carrito está vacío</p>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
                        <?php if (isset($products[$productId])): ?>
                            <div class="cart-item">
                                <div class="item-details">
                                    <h3><?php echo $products[$productId]['name']; ?></h3>
                                    <p class="price">$<?php echo number_format($products[$productId]['price'], 2); ?></p>
                                    <p class="quantity">Cantidad: <?php echo $quantity; ?></p>
                                    <p class="subtotal">Subtotal:
                                        $<?php echo number_format($products[$productId]['price'] * $quantity, 2); ?></p>
                                </div>
                                <form method="POST" class="remove-form" action="./controllers/cart/actions_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit" name="remove" class="remove-button">Eliminar</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="cart-summary">
                    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
                    <a href="index.php?acc=Checkout" class="checkout-button">Proceder al Pago</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>