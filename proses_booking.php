<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['booking'])) {
    $id_user = $_SESSION['id'];
    $id_layanan = $_POST['id_layanan'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];

    $cekJadwal = mysqli_query($conn, "SELECT * FROM pemesanan WHERE tanggal='$tanggal' AND jam='$jam'");
    if (mysqli_num_rows($cekJadwal) > 0) {
        echo "Slot sudah terisi. Silakan pilih jam lain.";
        exit;
    }

    $query = "INSERT INTO pemesanan (id_user, id_layanan, tanggal, jam, status)
              VALUES ('$id_user', '$id_layanan', '$tanggal', '$jam', 'pending')";

    if (mysqli_query($conn, $query)) {
        echo "Booking berhasil. Silakan lakukan pembayaran di tempat atau lewat kasir.";
    } else {
        echo "Gagal booking: " . mysqli_error($conn);
    }
}
?>