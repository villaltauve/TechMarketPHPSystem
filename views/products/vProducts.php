<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="assets/js/Products/Filtrado.js"></script>
    <script src="assets/js/favorites.js"></script>
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
            position: relative;
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
            color: #666;
            margin: 0.5rem 0;
        }

        .description {
            color: #666;
            margin: 0.5rem 0;
            flex-grow: 1;
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

        /* Estilos para los filtros */
        .filters-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 500;
            color: var(--text-color);
        }

        .filter-group input,
        .filter-group select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .filter-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .filter-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .apply-filters {
            background-color: var(--primary-color);
            color: white;
        }

        .clear-filters {
            background-color: #f8f9fa;
            color: var(--text-color);
            border: 1px solid #ddd;
        }

        .apply-filters:hover {
            background-color: var(--secondary-color);
        }

        .clear-filters:hover {
            background-color: #e9ecef;
        }

        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                flex-direction: column;
            }

            .filter-button {
                width: 100%;
            }
        }

        /* Estilos para el botón de favoritos */
        .favorite-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .favorite-button:hover {
            transform: scale(1.1);
        }

        .favorite-button i {
            font-size: 1.2rem;
            color: #666;
            transition: color 0.3s ease;
        }

        .favorite-active i {
            color: #ff4d4d;
        }

        /* Estilos para las notificaciones */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        .notification.success {
            background-color: #28a745;
        }

        .notification.error {
            background-color: #dc3545;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
    <main>
        <section class="products-section">
            <h2>Productos Disponibles</h2>
            
            <!-- Filtros mejorados -->
            <div class="filters-container">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="searchProduct">Buscar producto:</label>
                        <input type="text" id="searchProduct" name="searchProduct" placeholder="Nombre del producto...">
                    </div>

                    <div class="filter-group">
                        <label for="ordenPrecio">Ordenar por precio:</label>
                        <select id="ordenPrecio" name="ordenPrecio">
                            <option value="">Seleccionar orden</option>
                            <option value="alto">Más alto a más bajo</option>
                            <option value="bajo">Más bajo a más alto</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="precioMin">Precio mínimo:</label>
                        <input type="number" id="precioMin" name="precioMin" step="0.01" min="0" placeholder="0.00">
                    </div>

                    <div class="filter-group">
                        <label for="precioMax">Precio máximo:</label>
                        <input type="number" id="precioMax" name="precioMax" step="0.01" min="0" placeholder="0.00">
                    </div>

                    <div class="filter-group">
                        <label for="stockFilter">Stock disponible:</label>
                        <select id="stockFilter" name="stockFilter">
                            <option value="">Todos</option>
                            <option value="disponible">Con stock</option>
                            <option value="agotado">Sin stock</option>
                        </select>
                    </div>
                </div>

                <div class="filter-buttons">
                    <button class="filter-button apply-filters" onclick="filtrarProductos()">Aplicar Filtros</button>
                    <button class="filter-button clear-filters" onclick="limpiarFiltros()">Limpiar Filtros</button>
                </div>
            </div>

            <div id="resultadoProductos">
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <?php if ($isLoggedIn): ?>
                                <button class="favorite-button" data-product-id="<?php echo $product['id']; ?>">
                                    <i class="far fa-heart"></i>
                                </button>
                            <?php endif; ?>
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
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>