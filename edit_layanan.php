<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM layanan WHERE id = $id"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama', deskripsi='$deskripsi', harga='$harga' WHERE id=$id");
    header("Location: layanan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Layanan</title>
</head>
<body>
  <h2>Edit Layanan</h2>
  <form method="POST">
    <input type="text" name="nama" value="<?= $data['nama_layanan']; ?>" required><br><br>
    <textarea name="deskripsi" required><?= $data['deskripsi']; ?></textarea><br><br>
    <input type="number" name="harga" value="<?= $data['harga']; ?>" required><br><br>
    <button type="submit" name="update">Update</button>
  </form>
  <br><a href="layanan.php">Kembali</a>
</body>
</html>
