<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'operator') {
    header("Location: login.php");
    exit;
}

// Ambil pemesanan hari ini
$tanggal = date('Y-m-d');
$query = mysqli_query($conn, "
    SELECT p.*, u.nama AS nama_pelanggan, l.nama_layanan 
    FROM pemesanan p
    JOIN users u ON p.id_user = u.id
    JOIN layanan l ON p.id_layanan = l.id
    WHERE p.tanggal = '$tanggal'
    ORDER BY p.jam ASC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Operator - Antrian Hari Ini</title>
</head>
<body>
  <h2>Antrian Cuci Motor - Tanggal <?= $tanggal; ?></h2>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Jam</th>
      <th>Nama Pelanggan</th>
      <th>Layanan</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
    <tr>
      <td><?= $no++; ?></td>
      <td><?= $row['jam']; ?></td>
      <td><?= $row['nama_pelanggan']; ?></td>
      <td><?= $row['nama_layanan']; ?></td>
      <td><?= $row['status']; ?></td>
      <td>
        <?php if ($row['status'] != 'selesai'): ?>
          <form method="POST" action="../proses/update_status.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $row['id']; ?>">
            <select name="status" onchange="this.form.submit()">
              <option value="">-- Ganti Status --</option>
              <option value="dibayar">Dibayar</option>
              <option value="selesai">Selesai</option>
              <option value="batal">Batal</option>
            </select>
          </form>
        <?php else: ?>
          ✅
        <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br><a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
