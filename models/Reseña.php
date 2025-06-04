<?php
class Reseñas
{
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function buscarPorNombre($search = '')
    {
        $sql = "SELECT id, name, image, stock, price FROM products WHERE 1=1";
        $params = array();

        // Filtro por búsqueda
        if (!empty($search)) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }


        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    public function agregarResena($producto_id, $usuario_id, $calificacion, $comentario)
    {
        $sql = "INSERT INTO resenas (producto_id, usuario_id, calificacion, comentario) 
                VALUES (:producto_id, :usuario_id, :calificacion, :comentario)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_INT);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function obtenerResenasConProductoYUsuario()
    {
        $query = "SELECT r.*, p.name AS nombre_producto, u.username AS usuario
              FROM resenas r
              JOIN products p ON r.producto_id = p.id
              JOIN users u ON r.usuario_id = u.id
              ORDER BY r.fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

