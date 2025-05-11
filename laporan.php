<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Filter tanggal
$tanggal_awal = $_GET['awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['akhir'] ?? date('Y-m-d');

$query = mysqli_query($conn, "
    SELECT p.*, u.nama AS nama_pelanggan, l.nama_layanan, l.harga
    FROM pemesanan p
    JOIN users u ON p.id_user = u.id
    JOIN layanan l ON p.id_layanan = l.id
    WHERE p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    AND (p.status = 'dibayar' OR p.status = 'selesai')
    ORDER BY p.tanggal DESC, p.jam DESC
");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi - Admin</title>
</head>
<body>
  <h2>Laporan Transaksi</h2>

  <form method="GET">
    <label>Periode:</label><br>
    Dari <input type="date" name="awal" value="<?= $tanggal_awal; ?>" required>
    Sampai <input type="date" name="akhir" value="<?= $tanggal_akhir; ?>" required>
    <button type="submit">Tampilkan</button>
  </form>

  <br>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Jam</th>
      <th>Pelanggan</th>
      <th>Layanan</th>
      <th>Harga</th>
      <th>Status</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $total += $row['harga'];
        echo "<tr>
            <td>$no</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['jam']}</td>
            <td>{$row['nama_pelanggan']}</td>
            <td>{$row['nama_layanan']}</td>
            <td>Rp" . number_format($row['harga'], 0, ',', '.') . "</td>
            <td>{$row['status']}</td>
        </tr>";
        $no++;
    }
    ?>
  </table>

  <h3>Total Pendapatan: Rp<?= number_format($total, 0, ',', '.'); ?></h3>

  <br><a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
