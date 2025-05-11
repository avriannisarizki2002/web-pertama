<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil data pendapatan per hari 7 hari terakhir
$harian = mysqli_query($conn, "
    SELECT tanggal, SUM(l.harga) AS total
    FROM pemesanan p
    JOIN layanan l ON p.id_layanan = l.id
    WHERE p.status IN ('dibayar', 'selesai')
    GROUP BY tanggal
    ORDER BY tanggal DESC
    LIMIT 7
");

// Ambil data pendapatan per bulan 12 bulan terakhir
$bulanan = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(l.harga) AS total
    FROM pemesanan p
    JOIN layanan l ON p.id_layanan = l.id
    WHERE p.status IN ('dibayar', 'selesai')
    GROUP BY bulan
    ORDER BY bulan DESC
    LIMIT 12
");

// Format untuk Chart.js
$label_hari = [];
$data_hari = [];
while ($row = mysqli_fetch_assoc($harian)) {
    $label_hari[] = $row['tanggal'];
    $data_hari[] = $row['total'];
}

$label_bulan = [];
$data_bulan = [];
while ($row = mysqli_fetch_assoc($bulanan)) {
    $label_bulan[] = $row['bulan'];
    $data_bulan[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h2>Dashboard Admin - Grafik Pendapatan</h2>

  <h3>Pendapatan per Hari (7 Hari Terakhir)</h3>
  <canvas id="chartHarian" width="600" height="300"></canvas>

  <h3>Pendapatan per Bulan (12 Bulan Terakhir)</h3>
  <canvas id="chartBulanan" width="600" height="300"></canvas>

  <script>
    const labelHarian = <?= json_encode(array_reverse($label_hari)) ?>;
    const dataHarian = <?= json_encode(array_reverse($data_hari)) ?>;
    const ctx1 = document.getElementById('chartHarian').getContext('2d');
    new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: labelHarian,
        datasets: [{
          label: 'Rp Pendapatan',
          data: dataHarian,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    const labelBulanan = <?= json_encode(array_reverse($label_bulan)) ?>;
    const dataBulanan = <?= json_encode(array_reverse($data_bulan)) ?>;
    const ctx2 = document.getElementById('chartBulanan').getContext('2d');
    new Chart(ctx2, {
      type: 'line',
      data: {
        labels: labelBulanan,
        datasets: [{
          label: 'Rp Pendapatan',
          data: dataBulanan,
          fill: false,
          borderColor: 'rgba(255, 99, 132, 1)',
          tension: 0.1
        }]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
  </script>

  <br><a href="layanan.php">Kelola Layanan</a> | <a href="laporan.php">Laporan Lengkap</a>
</body>
</html>
