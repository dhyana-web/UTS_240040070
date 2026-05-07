<?php
require_once 'config/database.php';

$db = new database();
$conn = $db->getConnection();

if ($conn) {
    $conn->exec("CREATE DATABASE IF NOT EXISTS inventory_db");
    $conn->exec("USE inventory_db");

    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        type ENUM('Laptop', 'Smartphone') NOT NULL,
        stock INT NOT NULL CHECK (stock >= 0),
        price DECIMAL(10,2) NOT NULL
    )";
    $conn->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES products(id)
    )";
    $conn->exec($sql);

    $dummy_data = [
        "INSERT INTO products (name, type, stock, price) VALUES ('Asus VivoBook', 'Laptop', 3, 7500000)",
        "INSERT INTO products (name, type, stock, price) VALUES ('HP Pavilion', 'Laptop', 8, 6500000)",
        "INSERT INTO products (name, type, stock, price) VALUES ('iPhone 15', 'Smartphone', 2, 15000000)",
        "INSERT INTO products (name, type, stock, price) VALUES ('Samsung Galaxy S24', 'Smartphone', 10, 12000000)"
    ];

    foreach ($dummy_data as $insert) {
        try {
            $conn->exec($insert);
        } catch (PDOException $e) {
        }
    }

    echo "Database dan tabel berhasil dibuat.";
} else {
    echo "Koneksi database gagal.";
}
?>