<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Cuci Motor</title>
</head>
<body>
  <h2>Login Pengguna</h2>
  <form action="../proses/proses_login.php" method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
  </form>
  <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
</body>
</html>