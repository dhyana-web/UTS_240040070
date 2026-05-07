<?php
require_once 'classes/transaksi.php';
require_once 'classes/produk.php';

$transaction = new Transaksi();
$product = new Produk();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction->product_id = $_POST['product_id'];
    $transaction->quantity = $_POST['quantity'];
    if ($transaction->sell()) {
        $message = "Transaksi Berhasil.";
    } else {
        $message = "Transaction gagal, cek stok barang.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengelolaan Transaksi</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Pengelolaan Transaksi</h1>
    <p><?php echo $message; ?></p>

    <h2>Jual Produk</h2>
    <form method="post">
        <select name="product_id" required>
            <option value="">Select Product</option>
            <?php
            $stmt = $product->readAll();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . " (Stock: " . $row['stock'] . ")</option>";
            }
            ?>
        </select>
        <input type="number" name="quantity" placeholder="Quantity" min="1" required>
        <button type="submit">Sell</button>
    </form>

    <h2>RIwayat Transaksi</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Quantity Sold</th>
            <th>Date</th>
        </tr>
        <?php
        $stmt = $transaction->readAll();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="index.php">Kembali ke dashboard</a>
</body>
</html>