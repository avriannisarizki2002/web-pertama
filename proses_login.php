<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        // Redirect berdasarkan role
        header("Location: ../pages/dashboard.php");
        exit;
    } else {
        echo "Login gagal. Email atau password salah.";
    }
}
?>