<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
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
                            <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Agregar al
                                Carrito</button>
                        <?php endif; ?>
                        <a href="index.php?acc=ProductDetails&id=<?php echo $product['id']; ?>" class="view-details">Ver
                            Detalles</a>
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