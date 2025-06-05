<?php
require_once '../../config/database.php';
require_once '../../models/Reseña.php';

$search = $_GET['search'] ?? '';

$database = new Database();
$db = $database->getConnection();

$ReseñasModel = new Reseñas($db);
$productos = $ReseñasModel->buscarPorNombre($search); // Este método debe buscar por LIKE

foreach ($productos as $producto) {
    echo '<div class="resultado-item dark-suggestion" data-id="' . intval($producto['id']) . '">' . htmlspecialchars($producto['name']) . '</div>';
}
?>
