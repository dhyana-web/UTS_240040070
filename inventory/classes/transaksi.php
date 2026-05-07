<?php
require_once 'config/database.php';
require_once 'classes/Produk.php';

class Transaksi {
    private $conn;
    private $table_name = "transactions";

    public $id;
    public $product_id;
    public $quantity;
    public $date;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function sell() {
        
        $product = new Produk();
        $product->id = $this->product_id;
        $product->readOne();
        if ($product->stock < $this->quantity) {
            return false; 
        }
       
        $product->stock -= $this->quantity;
        if (!$product->update()) {
            return false;
        }
       
        $query = "INSERT INTO " . $this->table_name . " SET product_id=:product_id, quantity=:quantity";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT t.id, p.name, p.type, t.quantity, t.date FROM " . $this->table_name . " t JOIN products p ON t.product_id = p.id ORDER BY t.date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>