<?php
session_start();

$cerrar_session = $_GET['acc'];
// Cerrar sesión
if ($cerrar_session === "logout") {
    session_destroy();
    $isLoggedIn = false;
}

header("location: index.php?acc=Home");


?>