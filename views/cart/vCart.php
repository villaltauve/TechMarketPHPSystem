<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cart-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .cart-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .cart-items th,
        .cart-items td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-items th {
            background-color: var(--primary-color);
            color: white;
        }

        .cart-total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remove-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-button:hover {
            background-color: #c82333;
        }

        .checkout-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .checkout-button:hover {
            background-color: var(--secondary-color);
        }

        .empty-cart {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        .cart-message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            text-align: center;
        }

        .cart-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .cart-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
    <main>
        <div class="cart-container">
            <h1>Carrito de Compras</h1>
            
            <?php if (empty($cartProducts)): ?>
                <div class="empty-cart">
                    <p>Tu carrito está vacío</p>
                    <a href="index.php?acc=Products" class="checkout-button">Ver Productos</a>
                </div>
            <?php else: ?>
                <table class="cart-items">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartProducts as $productId => $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST" action="index.php?acc=Cart" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <input type="hidden" name="remove" value="1">
                                    <button type="submit" class="remove-button" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto del carrito?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">
                    <p>Total: $<?php echo number_format($total, 2); ?></p>
                </div>

                <div class="cart-actions">
                    <a href="index.php?acc=Products" class="checkout-button">Seguir Comprando</a>
                    <a href="index.php?acc=Checkout" class="checkout-button">Proceder al Pago</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>