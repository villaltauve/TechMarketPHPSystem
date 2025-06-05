<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if (!$isLoggedIn || empty($_SESSION['cart'])) {
    header('Location: index.php?acc=Home');
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../libs/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../../libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$cartProducts = [];
$total = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product->id = $productId;
    $productData = $product->readOne();
    
    if ($productData) {
        $cartProducts[$productId] = [
            'id' => $productData['id'],
            'name' => $productData['name'],
            'price' => $productData['price'],
            'quantity' => $quantity,
            'stock' => $productData['stock']
        ];
        $total += $productData['price'] * $quantity;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if ($name && $phone && $email) {
        foreach ($cartProducts as $productId => $item) {
            $product->id = $productId;
            $product->stock = $item['stock'] - $item['quantity'];
            $product->update();
        }

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        
        $_SESSION['invoice'] = [
            'number' => $invoiceNumber,
            'date' => date('Y-m-d H:i:s'),
            'customer' => [
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ],
            'items' => $cartProducts,
            'total' => $total
        ];

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'techmarktsv@gmail.com';
            $mail->Password   = 'olok sbsf uzog qviv';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('techmarktsv@gmail.com', 'Tech Market');
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Factura de tu compra - ' . $invoiceNumber;

            $body = "<h3>Gracias por tu compra, $name</h3>";
            $body .= "<p>Factura: <strong>$invoiceNumber</strong></p>";
            $body .= "<p>Total: <strong>$$total</strong></p>";
            $body .= "<ul>";
            foreach ($cartProducts as $item) {
                $body .= "<li>{$item['name']} x {$item['quantity']} - \$" . ($item['price'] * $item['quantity']) . "</li>";
            }
            $body .= "</ul>";
            $mail->Body = $body;

            $mail->send();
            echo "<script>alert('Se ha enviado la factura al correo.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error al enviar la factura: {$mail->ErrorInfo}');</script>";
        }

        $_SESSION['cart'] = [];

        header('Location: index.php?acc=Invoice');
        exit;
    }
}

require_once("./views/checkout/vCheckout.php");
