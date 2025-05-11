<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Ambil layanan dari database
$layanan = mysqli_query($conn, "SELECT * FROM layanan");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Booking Layanan Cuci Motor</title>
</head>
<body>
  <h2>Booking Cuci Motor</h2>

  <form action="../proses/proses_booking.php" method="POST">
    <label>Jenis Layanan:</label><br>
    <select name="id_layanan" required>
      <option value="">-- Pilih Layanan --</option>
      <?php while ($row = mysqli_fetch_assoc($layanan)): ?>
        <option value="<?= $row['id']; ?>">
          <?= $row['nama_layanan']; ?> - Rp<?= number_format($row['harga'], 0, ',', '.'); ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" required><br><br>

    <label>Jam:</label><br>
    <input type="time" name="jam" required><br><br>

    <button type="submit" name="booking">Kirim Booking</button>
  </form>

  <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</body>
</html>
