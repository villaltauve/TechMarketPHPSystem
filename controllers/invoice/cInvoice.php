<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Redirigir si no está logueado o no hay factura
if (!$isLoggedIn || !isset($_SESSION['invoice'])) {
    header('Location: index.php?acc=Home');
    exit;
}

$invoice = $_SESSION['invoice'];

require_once("./views/invoice/vInvoice.php");
?>
