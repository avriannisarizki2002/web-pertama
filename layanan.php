<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Tambah layanan
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO layanan (nama_layanan, deskripsi, harga) VALUES ('$nama', '$deskripsi', '$harga')");
    header("Location: layanan.php");
}

// Hapus layanan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM layanan WHERE id = $id");
    header("Location: layanan.php");
}

// Ambil data layanan
$data = mysqli_query($conn, "SELECT * FROM layanan");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola Layanan - Admin</title>
</head>
<body>
  <h2>Kelola Layanan Cuci Motor</h2>

  <h3>Tambah Layanan Baru</h3>
  <form method="POST">
    <input type="text" name="nama" placeholder="Nama layanan" required><br><br>
    <textarea name="deskripsi" placeholder="Deskripsi layanan" required></textarea><br><br>
    <input type="number" name="harga" placeholder="Harga (Rp)" required><br><br>
    <button type="submit" name="tambah">Tambah</button>
  </form>

  <h3>Daftar Layanan</h3>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Deskripsi</th>
      <th>Harga</th>
      <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
    <tr>
      <td><?= $no++; ?></td>
      <td><?= $row['nama_layanan']; ?></td>
      <td><?= $row['deskripsi']; ?></td>
      <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
      <td>
        <a href="edit_layanan.php?id=<?= $row['id']; ?>">Edit</a> | 
        <a href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br><a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
