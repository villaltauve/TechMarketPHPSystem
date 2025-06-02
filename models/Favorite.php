<?php
class Favorite {
    private $conn;
    private $table_name = "favorites";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addFavorite($user_id, $product_id) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, product_id) 
                  VALUES (:user_id, :product_id)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":product_id", $product_id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Si el error es por duplicado, retornamos false
            if ($e->getCode() == 23000) {
                return false;
            }
            throw $e;
        }
    }

    public function removeFavorite($user_id, $product_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND product_id = :product_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":product_id", $product_id);
        
        return $stmt->execute();
    }

    public function isFavorite($user_id, $product_id) {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND product_id = :product_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":product_id", $product_id);
        
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function getUserFavorites($user_id) {
        $query = "SELECT p.* FROM products p 
                  INNER JOIN " . $this->table_name . " f ON p.id = f.product_id 
                  WHERE f.user_id = :user_id 
                  ORDER BY f.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        return $stmt;
    }
}
?> 