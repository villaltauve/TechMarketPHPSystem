<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMarket - Tu Tienda de Tecnología</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
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
                foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <p class="description"><?php echo $product['description']; ?></p>
                        <?php if ($isLoggedIn): ?>
                            <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Agregar al
                                Carrito</button>
                        <?php endif; ?>
                        <a href="index.php?acc=ProductDetails&id=<?php echo $product['id']; ?>" class="view-details">Ver Detalles</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>