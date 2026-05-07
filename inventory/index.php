<?php
require_once 'classes/dashboard.php';
$dashboard = new Dashboard();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .alert { color: red; }
    </style>
</head>
<body>
    <h1>Inventory Dashboard</h1>

    <h2>Ringkasa Stock</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Stock</th>
            <th>Harga</th>
        </tr>
        <?php
        $stmt = $dashboard->getStockSummary();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h2>PERINGATAN STOCK</h2>
    <div class="alert">
        <?php
        $stmt = $dashboard->getLowStockAlerts();
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo "Stok Menipis untuk produk berikut:<br>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "- " . $row['name'] . " (Stok: " . $row['stock'] . ")<br>";
            }
        } else {
            echo "Semua produk memiliki stok cukup.";
        }
        ?>
    </div>

    <h2>Ringkasan Transaksi</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Tipe</th>
            <th>Terjual</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $stmt = $dashboard->getTransactionSummary();
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

    <a href="kelola_produk.php">Pengelolaan Produk</a> | <a href="kelola_transaksi.php">Pengelolaan Transaksi</a>
</body>
</html>
