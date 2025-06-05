<?php
require_once '../../config/database.php';
require_once '../../models/Product.php';

session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

$database = new Database();
$db = $database->getConnection();

$orden = $_GET['ordenPrecio'] ?? '';
$precioMin = $_GET['precioMin'] ?? '';
$precioMax = $_GET['precioMax'] ?? '';
$search = $_GET['search'] ?? '';
$stock = $_GET['stock'] ?? '';

$modelo = new Product($db);
$resultado = $modelo->filtrarProductos($orden, $precioMin, $precioMax, $search, $stock);

$products = $resultado->fetchAll(PDO::FETCH_ASSOC);

if (count($products) > 0) {
    echo '<div class="products-grid">';
    foreach ($products as $product) {
        echo '<div class="product-card">
                <div class="product-image-container">
                    <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" class="product-image">
                </div>
                <h3>' . htmlspecialchars($product['name']) . '</h3>
                <p class="price">$' . number_format($product['price'], 2) . '</p>
                <p class="stock">Stock disponible: ' . intval($product['stock']) . '</p>';
        
        if ($isLoggedIn && intval($product['stock']) > 0) {
            echo '<button class="add-to-cart" data-product-id="' . intval($product['id']) . '">Agregar al Carrito</button>';
        }

        echo '<a href="index.php?acc=ProductDetails&id=' . intval($product['id']) . '" class="view-details">Ver Detalles</a>
            </div>';
    }
    echo '</div>';
} else {
    echo '<div class="no-results">
            <p>No se encontraron productos con los filtros seleccionados.</p>
            <button class="filter-button clear-filters" onclick="limpiarFiltros()">Limpiar Filtros</button>
          </div>';
}
?>
