<?php
session_start();

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userRole = $_SESSION['role'] ?? null;

require_once './config/database.php';
require_once './models/Product.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $database = new Database();
    $db = $database->getConnection();

    // Consulta para obtener usuario por username
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar contraseña con password_verify
        if (password_verify($password, $user['password'])) {
            // Login exitoso, crear sesión
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $isLoggedIn = true;
            header("Location: index.php?acc=Home");
        exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}

// Obtener productos para mostrar en home
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php?acc=Home");
    exit();
}

require_once("./views/home/vHome.php");
?>
