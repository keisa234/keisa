
<?php
include 'config.php';

if (!isset($_SESSION['login']) ||
    $_SESSION['login']['role'] != 'administrator') {
    die("Akses hanya untuk administrator!");
}

if (isset($_POST['daftar'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = mysqli_prepare($conn,
        "INSERT INTO login (Nama, Username, Password, Role)
         VALUES (?, ?, ?, 'petugas')"
    );

    mysqli_stmt_bind_param($sql, "sss",
        $nama, $username, $password
    );

    if (mysqli_stmt_execute($sql)) {
        echo "<script>
            alert('Petugas berhasil didaftarkan!');
            window.location='register.php';
        </script>";
    } else {
        echo "<script>
            alert('Username sudah digunakan!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Petugas</title>
</head>
<body>

<h2>REGISTRASI PETUGAS</h2>

<form method="POST">

    <label>Nama Lengkap</label><br>
    <input type="text" name="nama" required>
    <br><br>

    <label>Username</label><br>
    <input type="text" name="username" required>
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>
    <br><br>

    <button type="submit" name="daftar">
        Daftar
    </button>

</form>

<br>

<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>
