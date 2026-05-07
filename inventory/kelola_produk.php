<?php
require_once 'classes/produk.php';

$product = new produk();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $product->name = $_POST['name'];
        $product->type = $_POST['type'];
        $product->stock = $_POST['stock'];
        $product->price = $_POST['price'];
        if ($product->create()) {
            $message = "Berhasil membuat produk.";
        } else {
            $message = "Gagal membuat produk. Pastikan input benar dan stok tidak negatif.";
        }
    } elseif (isset($_POST['update'])) {
        $product->id = $_POST['id'];
        $product->name = $_POST['name'];
        $product->type = $_POST['type'];
        $product->stock = $_POST['stock'];
        $product->price = $_POST['price'];
        if ($product->update()) {
            $message = "Berhasil mengupdate produk.";
        } else {
            $message = "Gagal mengupdate produk.";
        }
    } elseif (isset($_POST['delete'])) {
        $product->id = $_POST['id'];
        if ($product->delete()) {
            $message = "Produk berhasil dihapus.";
        } else {
            $message = "Gagal menghapus produk.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengelolaan Produk</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Pengelolaan Produk</h1>
    <p><?php echo $message; ?></p>

    <h2>Tambahkan Produk</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <select name="type" required>
            <option value="Laptop">Laptop</option>
            <option value="Smartphone">Smartphone</option>
        </select>
        <input type="number" name="stock" placeholder="Stock" min="0" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <button type="submit" name="create">Add</button>
    </form>

    <h2>Produk</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $product->readAll();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='text' name='name' value='" . $row['name'] . "' required>
                    <select name='type' required>
                        <option value='Laptop'" . ($row['type'] == 'Laptop' ? ' selected' : '') . ">Laptop</option>
                        <option value='Smartphone'" . ($row['type'] == 'Smartphone' ? ' selected' : '') . ">Smartphone</option>
                    </select>
                    <input type='number' name='stock' value='" . $row['stock'] . "' min='0' required>
                    <input type='number' step='0.01' name='price' value='" . $row['price'] . "' required>
                    <button type='submit' name='update'>Update</button>
                </form>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' name='delete' onclick='return confirm(\"Are you sure?\")'>Delete</button>
                </form>
            </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="index.php">Kembali ke dashboard</a>
</body>
</html>