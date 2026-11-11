
<?php
include 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM produk");
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$penjualan = mysqli_query($conn, "SELECT * FROM penjualan");

$total = mysqli_query($conn, "SELECT SUM(TotalHarga) AS total FROM penjualan");
$hasil = mysqli_fetch_assoc($total);
?>

<div class="sidebar">

    <h2>APLIKASI KASIR</h2>

    <div class="main">

    <h1>Dashboard</h1>

    <h3>
        Selamat Datang,
        <?= htmlspecialchars($_SESSION['login']['nama']); ?>
    </h3>

    <p>
        Jabatan:
        <?= htmlspecialchars($_SESSION['login']['role']); ?>
    </p>

    <a href="index.php">
    <?php if ($_SESSION['login']['role'] == 'administrator') { ?>
        <a href="register.php">Registrasi</a>
    <?php } ?>
    <a href="produk.php">Data Barang</a>
    <a href="transaksi.php">Pembelian</a>
    <a href="stok.php">Stok Barang</a>
    <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>
