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
            <?php $isEditing = isset($editingProduct); ?>
            <h3><?php echo $isEditing ? 'Editar Producto' : 'Agregar Nuevo Producto'; ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="product_id" value="<?php echo $editingProduct['id']; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $editingProduct['image']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Nombre del Producto:</label>
                    <input type="text" id="name" name="name" required value="<?php echo $isEditing ? $editingProduct['name'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="price">Precio:</label>
                    <input type="number" id="price" name="price" step="0.01" required value="<?php echo $isEditing ? $editingProduct['price'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" required value="<?php echo $isEditing ? $editingProduct['stock'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea id="description" name="description" required><?php echo $isEditing ? $editingProduct['description'] : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Imagen del Producto:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if ($isEditing): ?>
                        <p>Imagen actual: <img src="<?php echo $editingProduct['image']; ?>" width="50"></p>
                    <?php endif; ?>
                </div>

                <button type="submit" name="<?php echo $isEditing ? 'update_product' : 'add_product'; ?>">
                    <?php echo $isEditing ? 'Actualizar Producto' : 'Agregar Producto'; ?>
                </button>
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
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="edit_product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="edit-button">Editar</button>
                        </form>
                        <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                            <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="delete-button">Eliminar</button>
                        </form>
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
