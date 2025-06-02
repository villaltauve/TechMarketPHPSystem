<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/Favorite.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$favorite = new Favorite($db);

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$action = $_POST['action'] ?? '';

if (!$product_id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de producto no proporcionado']);
    exit;
}

switch ($action) {
    case 'add':
        if ($favorite->addFavorite($user_id, $product_id)) {
            echo json_encode(['success' => true, 'message' => 'Producto agregado a favoritos']);
        } else {
            echo json_encode(['success' => false, 'message' => 'El producto ya está en favoritos']);
        }
        break;

    case 'remove':
        if ($favorite->removeFavorite($user_id, $product_id)) {
            echo json_encode(['success' => true, 'message' => 'Producto removido de favoritos']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al remover el producto de favoritos']);
        }
        break;

    case 'check':
        $isFavorite = $favorite->isFavorite($user_id, $product_id);
        echo json_encode(['isFavorite' => $isFavorite]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
?> 