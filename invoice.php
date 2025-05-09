<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o no hay factura
if (!$isLoggedIn || !isset($_SESSION['invoice'])) {
    header('Location: index.php');
    exit;
}

$invoice = $_SESSION['invoice'];

// Simulación de productos (esto será reemplazado por la base de datos)
$products = [
    1 => ['name' => 'Laptop Gaming Pro', 'price' => 1299.99],
    2 => ['name' => 'Smartphone Ultra', 'price' => 899.99],
    3 => ['name' => 'Monitor 4K', 'price' => 499.99],
    4 => ['name' => 'Teclado Mecánico RGB', 'price' => 129.99],
    5 => ['name' => 'Mouse Gaming', 'price' => 79.99]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .invoice {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            box-shadow: var(--shadow);
            border-radius: 8px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .invoice-items th,
        .invoice-items td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-items th {
            background-color: var(--primary-color);
            color: white;
        }

        .invoice-total {
            text-align: right;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .print-button {
            display: block;
            margin: 2rem auto;
            padding: 1rem 2rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .print-button:hover {
            background-color: var(--secondary-color);
        }

        @media print {
            header, footer, .print-button {
                display: none;
            }

            .invoice {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">TechMarket</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="products.php">Productos</a></li>
                <li><a href="cart.php">Carrito</a></li>
                <li><a href="admin.php">Administrar</a></li>
                <li><a href="?logout=1">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="invoice">
            <div class="invoice-header">
                <h1>Factura Electrónica</h1>
                <p>TechMarket - Tu Tienda de Tecnología</p>
            </div>

            <div class="invoice-details">
                <div class="invoice-info">
                    <h3>Información de la Factura</h3>
                    <p><strong>Número de Factura:</strong> <?php echo $invoice['number']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo $invoice['date']; ?></p>
                </div>

                <div class="customer-info">
                    <h3>Información del Cliente</h3>
                    <p><strong>Nombre:</strong> <?php echo $invoice['customer']['name']; ?></p>
                    <p><strong>Teléfono:</strong> <?php echo $invoice['customer']['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $invoice['customer']['email']; ?></p>
                </div>
            </div>

            <table class="invoice-items">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice['items'] as $productId => $quantity): ?>
                        <?php if (isset($products[$productId])): ?>
                            <tr>
                                <td><?php echo $products[$productId]['name']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td>$<?php echo number_format($products[$productId]['price'], 2); ?></td>
                                <td>$<?php echo number_format($products[$productId]['price'] * $quantity, 2); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="invoice-total">
                <p>Total: $<?php echo number_format($invoice['total'], 2); ?></p>
            </div>

            <button onclick="window.print()" class="print-button">Imprimir Factura</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 TechMarket. Todos los derechos reservados.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 