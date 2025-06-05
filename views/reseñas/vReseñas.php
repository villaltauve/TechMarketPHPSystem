<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de productos</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/reseñas/Reseñas.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        #review-container {
            background: #fff;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        select,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(33, 99, 174);
        }

        #form-section {
            display: none;
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

        .dark-suggestion {
            background-color: #1e1e1e;
            color: #ffffff;
            border-bottom: 1px solid #333;
            padding: 10px;
        }

        .dark-suggestion:hover {
            background-color: #333333;
        }

        #reseñas-lista {
            margin-top: 40px;
        }

        .reseña-card {
            border: 1px solid rgb(53, 125, 203);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            color: rgb(0, 0, 0);
            box-shadow: 0 4px 8px rgba(80, 168, 255, 0.3);
            transition: transform 0.2s ease;
        }

        .reseña-card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(91, 160, 255, 0.4);
        }

        .reseña-card h3 {
            margin: 0 0 10px;
            color: #4a90e2;
            font-size: 1.2em;
        }

        .reseña-card p {
            margin: 6px 0;
            line-height: 1.4;
        }

        .reseña-card .fecha {
            font-size: 0.85em;
            color: #999;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>
    <main>
        <div id="review-container">
            <h2>Realizar una reseña a un producto</h2>

            <form action="controllers/reseñas/cProcesarReseña.php" method="POST">
                <div class="filter-group">
                    <label for="searchProduct">Buscar producto:</label>
                    <input type="text" id="searchProduct" name="searchProduct" placeholder="Nombre del producto...">
                    <input type="hidden" name="producto_id" id="producto_id">
                </div>
                <div id="resultadoProductos"></div>

                <div id="form-section">
                    <label for="calificacion">Calificación (1 a 10):</label>
                    <select name="calificacion" id="calificacion" required>
                        <option value="">Seleccione una calificación</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="comentario">Comentario:</label>
                    <textarea name="comentario" id="comentario" rows="5" placeholder="Escribe tu opinión aquí..."
                        required></textarea>
                    <button type="submit">Enviar Reseña</button>
                </div>
            </form>
        </div>

        <?php if (!empty($reseñas)): ?>
            <section id="reseñas-lista">
                <h2>Reseñas realizadas</h2>
                <?php foreach ($reseñas as $resena): ?>
                    <div class="reseña-card">
                        <h3><?= htmlspecialchars($resena['nombre_producto']) ?></h3>
                        <p><strong>Usuario:</strong> <?= htmlspecialchars($resena['usuario']) ?></p>
                        <p><strong>Calificación:</strong> <?= intval($resena['calificacion']) ?>/10</p>
                        <p><strong>Comentario:</strong> <?= nl2br(htmlspecialchars($resena['comentario'])) ?></p>
                        <p class="fecha"><em><?= htmlspecialchars($resena['fecha']) ?></em></p>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p>No hay reseñas registradas aún.</p>
        <?php endif; ?>

    </main>

    <script>
        // Mostrar el formulario cuando se selecciona un producto
        const productoSelect = document.getElementById('producto');
        const formSection = document.getElementById('form-section');

        productoSelect.addEventListener('change', function () {
            formSection.style.display = this.value ? 'block' : 'none';
        });
    </script>
</body>

</html>
<?php if (isset($estado)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const estado = "<?= htmlspecialchars($estado) ?>";
            if (estado === "ok") {
                alert("✅ Reseña añadida correctamente.");
                window.top.location.href = "index.php?acc=Reseñas";
            } else if (estado === "error") {
                alert("❌ Hubo un error al guardar la reseña.");
                window.top.location.href = "index.php?acc=Reseñas";
            } else if (estado === "incompleto") {
                alert("⚠️ Por favor complete todos los campos.");
                window.top.location.href = "index.php?acc=Reseñas";

            }
        });
    </script>
<?php endif; ?>