<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Akun - Cuci Motor</title>
</head>
<body>
  <h2>Form Registrasi Pengguna</h2>
  <form action="../proses/proses_daftar.php" method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>No HP:</label><br>
    <input type="text" name="no_hp" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">Daftar</button>
  </form>
</body>
</html>