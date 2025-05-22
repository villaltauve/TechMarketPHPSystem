

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .product-list {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .product-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .product-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-info h3 {
            margin: 0;
            color: var(--primary-color);
        }

        .product-info p {
            margin: 0.5rem 0;
            color: #666;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .product-actions button {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .edit-button {
            background-color: var(--secondary-color);
        }

        .delete-button {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    
    <?php require_once("./views/header/header.php");?>

    <main>
        <h2>Panel de Administración</h2>
        
        <div class="admin-container">
            <div class="product-form">
                <h3>Agregar Nuevo Producto</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nombre del Producto:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Precio:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Imagen del Producto:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    
                    <button type="submit" name="add_product">Agregar Producto</button>
                </form>
            </div>

            <div class="product-list">
                <h3>Productos Actuales</h3>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <div class="product-info">
                            <h3><?php echo $product['name']; ?></h3>
                            <p>Precio: $<?php echo number_format($product['price'], 2); ?></p>
                            <p>Stock: <?php echo $product['stock']; ?></p>
                        </div>
                        <div class="product-actions">
                            <button class="edit-button">Editar</button>
                            <button class="delete-button">Eliminar</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 