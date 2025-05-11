<?php
include '../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "Email sudah digunakan!";
        exit;
    }

    $query = "INSERT INTO users (nama, email, no_hp, password, role) 
              VALUES ('$nama', '$email', '$no_hp', '$password', 'customer')";

    if (mysqli_query($conn, $query)) {
        echo "Registrasi berhasil. <a href='../pages/login.php'>Login sekarang</a>";
    } else {
        echo "Registrasi gagal: " . mysqli_error($conn);
    }
}
?>