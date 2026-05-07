<?php
require_once 'config/database.php';


class Produk {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $type;
    public $stock;
    public $price;

    public function __construct() {
        $database = new database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        if ($this->stock < 0) {
            return false; 
        }
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, type=:type, stock=:stock, price=:price";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":price", $this->price);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->type = $row['type'];
        $this->stock = $row['stock'];
        $this->price = $row['price'];
    }

    public function update() {
        if ($this->stock < 0) {
            return false;
        }
        $query = "UPDATE " . $this->table_name . " SET name=:name, type=:type, stock=:stock, price=:price WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLowStock() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE stock < 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>