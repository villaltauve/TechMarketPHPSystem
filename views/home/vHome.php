<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMarket - Tu Tienda de Tecnología</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            padding: 1rem;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image-container {
            width: 100%;
            height: 200px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0.5rem;
        }

        .product-card h3 {
            margin: 0.5rem 0;
            font-size: 1.2rem;
            color: var(--text-color);
        }

        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 0.5rem 0;
        }

        .stock {
            color: #28a745;
            margin: 0.5rem 0;
        }

        .add-to-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            margin: 0.5rem 0;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: var(--secondary-color);
        }

        .view-details {
            display: block;
            text-align: center;
            color: var(--primary-color);
            text-decoration: none;
            margin-top: 0.5rem;
        }

        .view-details:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
                padding: 1rem;
            }

            .product-image-container {
                height: 150px;
            }
        }
    </style>
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
                $count = 0;
                foreach ($products as $product): 
                    if ($count >= 4) break;
                ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                        </div>
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <p class="stock">Stock disponible: <?php echo $product['stock']; ?></p>
                        <?php if ($isLoggedIn && $product['stock'] > 0): ?>
                            <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Agregar al Carrito</button>
                        <?php endif; ?>
                        <a href="index.php?acc=ProductDetails&id=<?php echo $product['id']; ?>" class="view-details">Ver Detalles</a>
                    </div>
                <?php 
                    $count++;
                endforeach; 
                ?>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="index.php?acc=Products" class="view-details" style="display: inline-block; padding: 1rem 2rem; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 4px;">Ver más productos</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>