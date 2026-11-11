<?php
include 'config.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($conn,
        "SELECT * FROM login WHERE Username='$username'");

    $data = mysqli_fetch_assoc($sql);
   
        $_SESSION['login'] = $data;

        header("Location: index.php");
        exit;

    } else {
        echo "Username atau Pasword salah!";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir</title>
</head>
<body>

<h2>LOGIN APLIKASI KASIR</h2>

<form method="POST">

    Username:
    <input type="text" name="username" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <button type="submit" name="login">Login</button>

</form>

</body>
</html>