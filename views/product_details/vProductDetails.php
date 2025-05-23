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

        @media (max-width: 768px) {
            .product-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
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
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>