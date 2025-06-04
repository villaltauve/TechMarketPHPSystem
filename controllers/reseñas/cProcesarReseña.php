<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Acceso no autorizado');
}

require_once '../../config/database.php';
require_once '../../models/Reseña.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'] ?? null;
    $calificacion = $_POST['calificacion'] ?? null;
    $comentario = trim($_POST['comentario'] ?? '');
    $usuario_id = $_SESSION['user_id'];

    if ($producto_id && $calificacion && $usuario_id) {
        $database = new Database();
        $db = $database->getConnection();

        $modelo = new Reseñas($db);
        $resultado = $modelo->agregarResena($producto_id, $usuario_id, $calificacion, $comentario);

        if ($resultado) {
            header('Location: ../../index.php?acc=Reseñas&estado=ok');
            exit;
        } else {
            header('Location: ../../index.php?acc=Reseñas&estado=error');
            exit;
        }
    } else {
        header('Location: ../../index.php?acc=Reseñas&estado=incompleto');
        exit;
    }
}
?>
