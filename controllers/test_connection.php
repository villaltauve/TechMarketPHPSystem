<?php
require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if($db) {
        echo "¡Conexión exitosa a la base de datos!";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 