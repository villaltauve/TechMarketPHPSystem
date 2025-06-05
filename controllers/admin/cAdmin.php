<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;


require_once './config/database.php';
require_once './models/Product.php';


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    
    header("Location: index.php?acc=Home");
    exit();
}


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    
    header("Location: index.php?acc=Home");
    exit();
}


if (!$isLoggedIn) {
    header('Location: index.php?acc=Home');
    exit;
}


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->stock = $_POST['stock'];
    
   
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $product->image = $uploadFile;
        } else {
            $product->image = 'assets/images/default.jpg';
        }
    } else {
        $product->image = 'assets/images/default.jpg';
    }
    
   
    if ($product->create()) {
       
        header('Location: index.php?acc=Admin');
        exit;
    } else {
        $error_message = "Error al agregar el producto";
    }


}


$editingProduct = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product_id'])) {
    $editingProduct = $product->getById($_POST['edit_product_id']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product->id = $_POST['product_id'];
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->stock = $_POST['stock'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
        $product->image = $uploadFile;
    } else {
        $product->image = $_POST['current_image'];
    }

    if ($product->update()) {
        header('Location: index.php?acc=Admin');
        exit;
    } else {
        $error_message = "Error al actualizar el producto";
    }
}

// Eliminar producto 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $productId = $_POST['delete_product_id'];
    
    if ($product->delete($productId)) {
        header('Location: index.php?acc=Admin'); 
        exit;
    } else {
        $error_message = "Error al eliminar el producto";
    }
}

// Obtener todos los productos de la base de datos
$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once("./views/admin/vAdmin.php");
?>