<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        // Si solo se está actualizando el stock
        if (isset($this->stock) && !isset($this->name)) {
            $query = "UPDATE products SET stock = :stock WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':stock', $this->stock);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        }
        
        // Si se está actualizando el producto completo
        $query = "UPDATE products SET 
                    name = :name, 
                    description = :description, 
                    price = :price, 
                    stock = :stock, 
                    image = :image 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->image = htmlspecialchars(strip_tags($this->image));

        // Vincular parámetros
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name = :name, description = :description, price = :price, 
                     stock = :stock, image = :image";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->image = htmlspecialchars(strip_tags($this->image));
        
        // Vincular parámetros
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":image", $this->image);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function filtrarProductos($orden, $precioMin, $precioMax, $search = '', $stock = '') {
        $sql = "SELECT id, name, image, stock, price FROM products WHERE 1=1";
        $params = array();

        // Filtro por búsqueda
        if (!empty($search)) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        // Filtro por precio mínimo
        if ($precioMin !== '' && is_numeric($precioMin)) {
            $sql .= " AND price >= :precioMin";
            $params[':precioMin'] = floatval($precioMin);
        }

        // Filtro por precio máximo
        if ($precioMax !== '' && is_numeric($precioMax) && floatval($precioMax) > 0) {
            $sql .= " AND price <= :precioMax";
            $params[':precioMax'] = floatval($precioMax);
        }

        // Filtro por stock
        if ($stock === 'disponible') {
            $sql .= " AND stock > 0";
        } elseif ($stock === 'agotado') {
            $sql .= " AND stock = 0";
        }

        // Ordenamiento
        if ($orden === 'alto') {
            $sql .= " ORDER BY price DESC";
        } elseif ($orden === 'bajo') {
            $sql .= " ORDER BY price ASC";
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }
}
?>