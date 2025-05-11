<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Selamat datang, <?php echo $_SESSION['nama']; ?>!</h2>
<p>Role: <?php echo $_SESSION['role']; ?></p>
<a href="logout.php">Logout</a>