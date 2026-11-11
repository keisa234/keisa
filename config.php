<?php
session_start();

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "aplikasi_kasir"
);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function wajibLogin() {
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
}

function hanyaAdmin() {
    wajibLogin();

    if ($_SESSION['login']['Role'] != 'administrator') {
        die("Anda tidak memiliki akses!");
    }
}
?>