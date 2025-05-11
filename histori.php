<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
$query = mysqli_query($conn, "
    SELECT p.*, l.nama_layanan, l.harga 
    FROM pemesanan p 
    JOIN layanan l ON p.id_layanan = l.id 
    WHERE p.id_user = '$id_user' 
    ORDER BY p.tanggal DESC, p.jam DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Histori Pemesanan</title>
</head>
<body>
  <h2>Histori Pemesanan Anda</h2>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Layanan</th>
      <th>Tanggal</th>
      <th>Jam</th>
      <th>Harga</th>
      <th>Status</th>
    </tr>

    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
            <td>$no</td>
            <td>{$row['nama_layanan']}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['jam']}</td>
            <td>Rp" . number_format($row['harga'], 0, ',', '.') . "</td>
            <td>{$row['status']}</td>
        </tr>";
        $no++;
    }
    ?>
  </table>

  <br>
  <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
