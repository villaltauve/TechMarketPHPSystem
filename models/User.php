<?php
class User {
    private $conn;
    private $table = "users";

    public $username;
    public $email;
    public $password;
    public $name;
    public $phone;

    public function __construct($db) {
        $this->conn = $db;
    }

   public function userExists($username, $email) {
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

    public function register() {
        $query = "INSERT INTO " . $this->table . " (username, email, password, name, phone) 
                  VALUES (:username, :email, :password, :name, :phone)";
        $stmt = $this->conn->prepare($query);

       
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->name = $this->name !== null ? htmlspecialchars(strip_tags($this->name)) : null;
        $this->phone = $this->phone !== null ? htmlspecialchars(strip_tags($this->phone)) : null;

        // Hashear la contraseña
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone', $this->phone);

        return $stmt->execute();
    }
}

