<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['role'] != 'operator') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE pemesanan SET status='$status' WHERE id=$id");
}

header("Location: ../pages/operator.php");
