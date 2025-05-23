<?php
class Cart {
    private $conn;
    private $table_name = "detalles_pedido";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($usuario_id, $producto_id, $cantidad) {
        // Verificar si el producto existe y tiene stock
        $product_query = "SELECT precio, stock FROM productos WHERE id = ?";
        $product_stmt = $this->conn->prepare($product_query);
        $product_stmt->bindParam(1, $producto_id);
        $product_stmt->execute();
        $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product || $product['stock'] < $cantidad) {
            return false;
        }
        
        // Verificar si el usuario tiene un pedido pendiente
        $pedido_query = "SELECT id FROM pedidos WHERE usuario_id = ? AND estado = 'pendiente' LIMIT 1";
        $pedido_stmt = $this->conn->prepare($pedido_query);
        $pedido_stmt->bindParam(1, $usuario_id);
        $pedido_stmt->execute();
        $pedido = $pedido_stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$pedido) {
            // Crear nuevo pedido
            $insert_pedido = "INSERT INTO pedidos (usuario_id, total) VALUES (?, 0)";
            $pedido_stmt = $this->conn->prepare($insert_pedido);
            $pedido_stmt->bindParam(1, $usuario_id);
            $pedido_stmt->execute();
            $pedido_id = $this->conn->lastInsertId();
        } else {
            $pedido_id = $pedido['id'];
        }
        
        // Verificar si el producto ya está en el carrito
        $detalle_query = "SELECT id, cantidad FROM detalles_pedido WHERE pedido_id = ? AND producto_id = ?";
        $detalle_stmt = $this->conn->prepare($detalle_query);
        $detalle_stmt->bindParam(1, $pedido_id);
        $detalle_stmt->bindParam(2, $producto_id);
        $detalle_stmt->execute();
        $detalle = $detalle_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($detalle) {
            // Actualizar cantidad
            $nueva_cantidad = $detalle['cantidad'] + $cantidad;
            $update_query = "UPDATE detalles_pedido SET cantidad = ?, precio_unitario = ? WHERE id = ?";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bindParam(1, $nueva_cantidad);
            $update_stmt->bindParam(2, $product['precio']);
            $update_stmt->bindParam(3, $detalle['id']);
            $update_stmt->execute();
        } else {
            // Agregar nuevo item
            $insert_query = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bindParam(1, $pedido_id);
            $insert_stmt->bindParam(2, $producto_id);
            $insert_stmt->bindParam(3, $cantidad);
            $insert_stmt->bindParam(4, $product['precio']);
            $insert_stmt->execute();
        }
        
        // Actualizar total del pedido
        $this->updateOrderTotal($pedido_id);
        
        return true;
    }
    
    private function updateOrderTotal($pedido_id) {
        $total_query = "SELECT SUM(cantidad * precio_unitario) as total FROM detalles_pedido WHERE pedido_id = ?";
        $total_stmt = $this->conn->prepare($total_query);
        $total_stmt->bindParam(1, $pedido_id);
        $total_stmt->execute();
        $total = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $update_query = "UPDATE pedidos SET total = ? WHERE id = ?";
        $update_stmt = $this->conn->prepare($update_query);
        $update_stmt->bindParam(1, $total);
        $update_stmt->bindParam(2, $pedido_id);
        $update_stmt->execute();
    }
}
?>