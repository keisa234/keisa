<?php
require 'config.php';
wajibLogin();

$pesan = "";

if (isset($_POST['tambah'])) {

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare(
        "INSERT INTO produk (nama, harga, stok)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sdi", $nama, $harga, $stok);

    if ($stmt->execute()) {
        header("Location: produk.php");
        exit;
    } else {
        $pesan = "Gagal menambah produk!";
    }
}

if (isset($_POST['edit'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare(
        "UPDATE produk
         SET nama=?, harga=?, stok=?
         WHERE id=?"
    );

    $stmt->bind_param("sdii", $nama, $harga, $stok, $id);

    if ($stmt->execute()) {
        header("Location: produk.php");
        exit;
    } else {
        $pesan = "Gagal mengedit produk!";
    }
}

if (isset($_POST['hapus'])) {

    $id = $_POST['id'];

    $stmt = $conn->prepare(
        "DELETE FROM produk WHERE id=?"
    );

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: produk.php");
        exit;
    } else {
        $pesan = "Produk sudah digunakan dalam transaksi dan tidak dapat dihapus.";
    }
}

$editData = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $stmt = $conn->prepare(
        "SELECT * FROM produk WHERE id=?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $editData = $stmt->get_result()->fetch_assoc();
}

$data = $conn->query(
    "SELECT * FROM produk ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">

    <h1>Data Produk</h1>

    <a href="index.php">Dashboard</a>

    <hr>

    <h3><?= $editData ? 'Edit Produk' : 'Tambah Produk'; ?></h3>

    <p><?= htmlspecialchars($pesan); ?></p>

    <form method="POST">

        <?php if ($editData) { ?>

            <input type="hidden" name="id"
            value="<?= $editData['id']; ?>">

        <?php } ?>

        <input type="text"
        name="nama"
        placeholder="Nama Produk"
        value="<?= htmlspecialchars($editData['NamaProduk'] ?? ''); ?>"
        required>

        <input type="number"
        name="harga"
        placeholder="Harga Produk"
        min="0"
        value="<?= $editData['Harga'] ?? ''; ?>"
        required>

        <input type="number"
        name="stok"
        placeholder="Stok Produk"
        min="0"
        value="<?= $editData['Stok'] ?? ''; ?>"
        required>

        <?php if ($editData) { ?>

            <button name="edit">Simpan Perubahan</button>
            <a href="produk.php">Batal</a>

        <?php } else { ?>

            <button name="tambah">Tambah Produk</button>

        <?php } ?>

    </form>

    <hr>

    <h3>Daftar Produk</h3>

    <table>

        <tr>
            <th>No</th>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>

        <?php while ($row = $data->fetch_assoc()) { ?>

        <tr>

            <td><?= $no++; ?></td>

            <td><?= $row['id']; ?></td>

            <td><?= htmlspecialchars($row['nama']); ?></td>

            <td>Rp <?= number_format($row['harga']); ?></td>

            <td><?= $row['stok']; ?></td>

            <td>

                <a href="produk.php?edit=<?= $row['id']; ?>">
                    Edit
                </a>

                <form method="POST"
                style="display:inline"
                onsubmit="return confirm('Yakin ingin menghapus produk?')">

                    <input type="hidden"
                    name="id"
                    value="<?= $row['id']; ?>">

                    <button name="hapus">Hapus</button>

                </form>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>