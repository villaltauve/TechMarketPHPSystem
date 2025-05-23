<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - TechMarket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .invoice-details {
            margin-bottom: 2rem;
        }

        .invoice-details p {
            margin: 0.5rem 0;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .invoice-items th,
        .invoice-items td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-items th {
            background-color: var(--primary-color);
            color: white;
        }

        .invoice-total {
            text-align: right;
            font-size: 1.2rem;
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

            header,
            footer,
            .print-button {
                display: none;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
    <main>
        <div class="invoice-container">
            <div class="invoice-header">
                <h1>Factura</h1>
                <p>Número: <?php echo $invoice['number']; ?></p>
                <p>Fecha: <?php echo $invoice['date']; ?></p>
            </div>

            <div class="invoice-details">
                <h2>Datos del Cliente</h2>
                <p><strong>Nombre:</strong> <?php echo $invoice['customer']['name']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $invoice['customer']['phone']; ?></p>
                <p><strong>Email:</strong> <?php echo $invoice['customer']['email']; ?></p>
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
                    <?php foreach ($invoice['items'] as $item): ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
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
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>